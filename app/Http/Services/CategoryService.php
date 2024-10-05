<?php

namespace App\Http\Services;

use App\Events\CategoryEvent;
use App\Models\Category;

class CategoryService
{
    /**
     * Get all categories
     * @return Collection Category
     */
    public function getAllCategories()
    {
        return Category::all();
    }

    /**
     * Create a new Category.
     *
     * @param  array  $data
     * @return \App\Models\Category
     */
    public function save(array $data): Category
    {
        $category = Category::create($data);

        // Déclencher un événement
        event(new CategoryEvent($category, 'created'));

        return $category;
    }

    /**
     * Get single category by giving id
     * @param mixed $id
     * @return single category
     */
    public function getCategoryById($id): ?Category
    {
        return Category::find($id);
    }

    /**
     * Update category by giving id
     * @param mixed $id
     * @param array $data
     * @return $category
     */
    public function updateCategory($id, array $data): ?Category
    {
        $category = Category::find($id);

        if ($category) {
            $category->update($data);

            event(new CategoryEvent($category, 'updated'));
        }


        return $category;
    }

    /**
     * Delete category
     * @param mixed $id
     * @return $category
     */
    public function deleteCategory($id)
    {
        $category = Category::find($id);
        
        if ($category) {
            $category->delete();

            event(new CategoryEvent($category, 'deleted'));
        }

        return $category;
    }
}
