<?php

namespace App\Services;

use App\Repositories\ItemRepository;

class ItemService
{
    /**
     * ItemRepository instance
     *
     * @var \App\Repositories\ItemRepository
     */
    protected $itemRepository;

    /**
     * Constructor
     *
     * @param \App\Repositories\ItemRepository $itemRepository
     */
    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * Get all items
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->itemRepository->all();
    }

    /**
     * Find an item by ID
     *
     * @param int $id
     * @return \App\Models\Item
     */
    public function find($id)
    {
        return $this->itemRepository->find($id);
    }

    /**
     * Create a new item
     *
     * @param array $data
     * @return \App\Models\Item
     */
    public function create(array $data)
    {
        return $this->itemRepository->create($data);
    }

    /**
     * Update an existing item
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Item
     */
    public function update($id, array $data)
    {
        return $this->itemRepository->update($id, $data);
    }

    /**
     * Delete an item
     *
     * @param int $id
     * @return bool|null
     */
    public function delete($id)
    {
        return $this->itemRepository->delete($id);
    }
}