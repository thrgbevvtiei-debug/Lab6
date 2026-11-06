<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Models\Car;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query()->withTranslation()->withCount('features');

        // Фільтрація: якщо brand немає в запиті, показуємо всі авто
        if ($request->filled('brand')) {
            $query->where('brand', $request->query('brand'));
        }

        // withQueryString() зберігає ?brand=... при переході між сторінками
        $cars = $query->orderBy('brand')
            ->orderBy('model')
            ->paginate(5)
            ->withQueryString();

        $brands = Car::query()->distinct()->orderBy('brand')->pluck('brand');

        return view('cars.index', compact('cars', 'brands'));
    }

    public function create()
    {
        return view('cars.create', [
            'features' => Feature::orderBy('name')->pluck('name', 'id'),
            'selected' => [],
        ]);
    }

    public function store(CarRequest $request)
    {
        $data = $request->validated();

        $car = Car::create(Arr::except($data, ['features']));
        $car->features()->sync($data['features'] ?? []);

        return redirect()->route('cars.index')->with('success', 'Авто успішно додано.');
    }

    public function show(Car $car)
    {
        $car->load([
            'features',
            'translations' => fn ($q) => $q->whereIn(
                'locale',
                array_unique([app()->getLocale(), config('app.fallback_locale')])
            ),
        ]);

        return view('cars.show', compact('car'));
    }

    public function edit(Car $car)
    {
        $car->load('features');

        return view('cars.edit', [
            'car'      => $car,
            'features' => Feature::orderBy('name')->pluck('name', 'id'),
            'selected' => $car->features->pluck('id')->all(),
        ]);
    }

    public function update(CarRequest $request, Car $car)
    {
        $data = $request->validated();

        $car->update(Arr::except($data, ['features']));
        $car->features()->sync($data['features'] ?? []);

        return redirect()->route('cars.index')->with('success', 'Дані авто оновлено.');
    }

    public function destroy(Car $car)
    {
        $car->delete();

        return redirect()->route('cars.index')->with('success', 'Авто видалено.');
    }
}
