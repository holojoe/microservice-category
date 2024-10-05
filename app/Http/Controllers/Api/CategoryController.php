<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Services\CategoryService;
use Illuminate\Http\JsonResponse;


class CategoryController extends Controller
{
    protected $categoryService;

    // Constructor to injecting the service
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Get categories list
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->categoryService->getAllCategories());
    }

    /**
     * Create a new Category
     * @param \App\Http\Requests\CategoryCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryCreateRequest $request): JsonResponse
    {
        // Validate the data in Request
        $category = $this->categoryService->save($request->validated());

        return response()->json([
            'status' => 201,
            'message' => 'Catégorie créée avec succès',
            'category' => $category
        ], 201);
    }

    /**
     * Gets a single category by given the id
     * @param mixes $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {

        $category = $this->findCategoryOrFail($id);
        if (is_null($category)) {
            return response()->json([
                'message' => 'Categorie avec l\' identifiant: ' . $id . ' n\'est pas.',
                'status' => 404
            ], 404);
        }
        $singleCategory = $this->categoryService->getCategoryById($id);

        return response()->json($singleCategory);
    }

    /**
     * Update a category by giving the $request and $id
     * @param mixes $id
     * @param @param \App\Http\Requests\CategoryUpdateRequest $request
     * * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryUpdateRequest $request, $id): JsonResponse
    {
        $category =  $this->findCategoryOrFail($id);
        if (is_null($category)) {
            return response()->json([
                'message' => 'Categorie avec l\' identifiant: ' . $id . ' n\'est pas.',
                'status' => 404
            ], 404);
        }
        $updatedCategory = $this->categoryService->updateCategory($id, $request->validated());

        $message = $request->has('name')
            ? $request->name . ' mis à jour avec succès.'
            : 'Catégorie mise à jour avec succès.';

        return response()->json([
            'status' => 200,
            'data' => $updatedCategory,
            'message' => $message
        ], 200);
    }

    /**
     * Deletes the category by giving the id
     * @param mixed $id
     * @return a deleted message.
     */
    public function destroy($id): JsonResponse
    {
        $category = $this->findCategoryOrFail($id);
        if (is_null($category)) {
            return response()->json([
                'message' => 'Categorie avec l\' identifiant: ' . $id . ' n\'est pas.',
                'status' => 404
            ], 404);
        }

        $this->categoryService->deleteCategory($id);

        return response()->json([
            'status' => 200,
            'message' => 'supprimée avec succès.'
        ], 200);
    }

    #region Private Methods
    private function findCategoryOrFail($id)
    {
        return $this->categoryService->getCategoryById($id);
    }
    #endRegion
}
