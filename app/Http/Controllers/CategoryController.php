<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount([
            'tickets',
            'tickets as active_tickets_count' => fn ($query) => $query
                ->whereNotIn('status', ['resolved', 'closed']),
        ])->orderBy('name')->get();

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80', 'unique:categories,name'],
            'icon' => ['nullable', 'string', 'max:12'],
        ]);

        Category::create($validated);

        return back()->with('success', 'Categoria criada com sucesso.');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80', Rule::unique('categories', 'name')->ignore($category)],
            'icon' => ['nullable', 'string', 'max:12'],
        ]);

        $category->update($validated);

        return back()->with('success', 'Categoria atualizada.');
    }

    public function destroy(Category $category)
    {
        if ($category->tickets()->exists()) {
            return back()->with('error', 'Essa categoria possui chamados e não pode ser excluída.');
        }

        $category->delete();

        return back()->with('success', 'Categoria removida.');
    }
}
