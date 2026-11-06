<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BlogController extends Controller
{
    // Публічний перелік (картки) з фільтром за міткою
    public function index(Request $request)
    {
        $request->validate([
            'filter' => ['nullable', 'integer', 'exists:filter,filter_id'],
        ]);

        $filterId = $request->query('filter');

        $blogs = Blog::withTranslation()
            ->with(['category', 'author', 'filters'])
            ->when(
                $filterId,
                fn ($query) => $query->whereHas(
                    'filters',
                    fn ($q) => $q->whereKey($filterId)
                )
            )
            ->orderByDesc('dt_created')
            ->paginate(6)
            ->withQueryString();

        $filters = Filter::pluck('filter_name', 'filter_id');

        return view('blog.index', compact('blogs', 'filters', 'filterId'));
    }

    // Адміністративний перелік (таблиця)
    public function admin()
    {
        $blogs = Blog::withTranslation()
            ->with('category')
            ->withCount('filters')
            ->orderByDesc('dt_created')
            ->paginate(10);

        return view('blog.admin', compact('blogs'));
    }

    public function create()
    {
        return view('blog.create', [
            'categories' => Category::orderBy('category_name')
                ->pluck('category_name', 'category_id'),
            'filters'    => Filter::pluck('filter_name', 'filter_id'),
            'selected'   => [],
        ]);
    }

    public function store(BlogRequest $request)
    {
        $data = $request->validated();

        $blog = Blog::create([
            ...Arr::except($data, ['filters']),
            'user_id' => auth()->id(),
        ]);

        $blog->filters()->sync($data['filters'] ?? []);

        return redirect()->route('blog.show', $blog)
            ->with('success', 'Запис створено.');
    }

    public function show(Blog $blog)
    {
        $blog->load([
            'category',
            'author',
            'filters',
            'translations' => fn ($q) => $q->where('locale', app()->getLocale()),
        ]);

        return view('blog.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $blog->load('filters');

        return view('blog.edit', [
            'blog'       => $blog,
            'categories' => Category::orderBy('category_name')
                ->pluck('category_name', 'category_id'),
            'filters'    => Filter::pluck('filter_name', 'filter_id'),
            'selected'   => $blog->filters->pluck('filter_id')->all(),
        ]);
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $data = $request->validated();

        $blog->update(Arr::except($data, ['filters']));
        $blog->filters()->sync($data['filters'] ?? []);

        return redirect()->route('blog.show', $blog)
            ->with('success', 'Запис оновлено.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('blog.admin')
            ->with('success', 'Запис видалено.');
    }

    // Сторінка керування мітками (DualListBox)
    public function tags(Blog $blog)
    {
        $blog->load('filters');

        return view('blog.tags', [
            'blog'     => $blog,
            'filters'  => Filter::pluck('filter_name', 'filter_id'),
            'selected' => $blog->filters->pluck('filter_id')->all(),
        ]);
    }

    public function tagsStore(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'filters'   => ['sometimes', 'array'],
            'filters.*' => ['integer', 'distinct', 'exists:filter,filter_id'],
        ]);

        $blog->filters()->sync($data['filters'] ?? []);

        return redirect()->route('blog.show', $blog)
            ->with('success', 'Мітки збережено.');
    }
}
