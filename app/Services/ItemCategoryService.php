<?php

namespace App\Services;

use App\Repositories\ItemCategoryRepository;

class ItemCategoryService
{
    /**
     * ItemCategoryRepository instance
     *
     * @var \App\Repositories\ItemCategoryRepository
     */
    protected $itemCategoryRepository;

    /**
     * Constructor
     *
     * @param \App\Repositories\ItemCategoryRepository $itemCategoryRepository
     */
    public function __construct(ItemCategoryRepository $itemCategoryRepository)
    {
        $this->itemCategoryRepository = $itemCategoryRepository;
    }

    /**
     * Get all item categories
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->itemCategoryRepository->all();
    }

    /**
     * Find an item category by ID
     *
     * @param int $id
     * @return \App\Models\ItemCategory
     */
    public function find($id)
    {
        return $this->itemCategoryRepository->find($id);
    }

    /**
     * Create a new item category
     *
     * @param array $data
     * @return \App\Models\ItemCategory
     */
    public function create(array $data)
    {
        return $this->itemCategoryRepository->create($data);
    }

    /**
     * Update an existing item category
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\ItemCategory
     */
    public function update($id, array $data)
    {
        return $this->itemCategoryRepository->update($id, $data);
    }

    /**
     * Delete an item category
     *
     * @param int $id
     * @return bool|null
     */
    public function delete($id)
    {
        return $this->itemCategoryRepository->delete($id);
    }
}
