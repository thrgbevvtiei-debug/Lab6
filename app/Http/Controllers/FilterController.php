<?php

namespace App\Http\Controllers;

use App\Models\Filter;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function index()
    {
        $filters = Filter::withCount('blogs')
            ->orderBy('filter_name')
            ->paginate(10);

        return view('filters.index', compact('filters'));
    }

    public function create()
    {
        return view('filters.create');
    }

    public function store(Request $request)
    {
        Filter::create($this->validated($request));

        return redirect()->route('filters.index')
            ->with('success', 'Мітку додано.');
    }

    public function edit(Filter $filter)
    {
        return view('filters.edit', compact('filter'));
    }

    public function update(Request $request, Filter $filter)
    {
        $filter->update($this->validated($request, $filter));

        return redirect()->route('filters.index')
            ->with('success', 'Мітку оновлено.');
    }

    public function destroy(Filter $filter)
    {
        // Рядки blog_filter видаляються каскадно, записи блогу лишаються
        $filter->delete();

        return redirect()->route('filters.index')
            ->with('success', 'Мітку видалено.');
    }

    private function validated(Request $request, ?Filter $filter = null): array
    {
        return $request->validate([
            'filter_name' => [
                'required', 'string', 'max:100',
                'unique:filter,filter_name' . ($filter ? ',' . $filter->filter_id . ',filter_id' : ''),
            ],
            'filter_description' => ['nullable', 'string', 'max:1000'],
        ], [
            'filter_name.required' => 'Вкажіть назву мітки.',
            'filter_name.unique'   => 'Така мітка вже існує.',
        ]);
    }
}
