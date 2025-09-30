<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Models\Item;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Get all orders
     */
    public function all()
    {
        return $this->orderRepository->all();
    }

    /**
     * Find an order by ID
     */
    public function find($id)
    {
        return $this->orderRepository->find($id);
    }

    /**
     * Create a new order with total_amount calculation
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            // Validate customer_id exists
            if (!DB::table('customers')->where('id', $data['customer_id'])->exists()) {
                throw new Exception('Customer does not exist.');
            }

            // Prepare items and calculate total_amount
            $totalAmount = 0;
            $syncItems = [];

            foreach ($data['items'] as $i) {
                $item = Item::find($i['item_id']);
                if (!$item) {
                    throw new Exception("Item ID {$i['item_id']} does not exist.");
                }

                $totalAmount += $item->price * $i['qty'];

                $syncItems[$i['item_id']] = [
                    'quantity' => $i['qty'],
                    'price'    => $item->price
                ];
            }

            if (empty($syncItems)) {
                throw new Exception('No valid items provided for order.');
            }

            // Create order
            $orderData = [
                'customer_id' => $data['customer_id'],
                'order_date'  => $data['order_date'] ?? now(),
                'status'      => $data['status'] ?? 'pending',
                'total_amount'=> $totalAmount
            ];

            Log::info('Creating order:', $orderData);

            $order = $this->orderRepository->create($orderData);

            // Attach items to pivot table safely
            $order->items()->sync($syncItems);

            DB::commit();

            return $order->load('items', 'customer');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed: ' . $e->getMessage());
            throw new Exception('Order creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Update order with items and total_amount
     */
    public function update($id, array $data)
    {
        DB::beginTransaction();

        try {
            $order = $this->orderRepository->find($id);

            if (!DB::table('customers')->where('id', $data['customer_id'])->exists()) {
                throw new Exception('Customer does not exist.');
            }

            $totalAmount = 0;
            $syncItems = [];

            foreach ($data['items'] as $i) {
                $item = Item::find($i['item_id']);
                if (!$item) {
                    throw new Exception("Item ID {$i['item_id']} does not exist.");
                }

                $totalAmount += $item->price * $i['qty'];
                $syncItems[$i['item_id']] = [
                    'quantity' => $i['qty'],
                    'price'    => $item->price
                ];
            }

            $updateData = [
                'customer_id'  => $data['customer_id'],
                'order_date'   => $data['order_date'] ?? $order->order_date,
                'status'       => $data['status'] ?? $order->status,
                'total_amount' => $totalAmount
            ];

            $order = $this->orderRepository->update($id, $updateData);

            $order->items()->sync($syncItems);

            DB::commit();

            return $order->load('items', 'customer');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Order update failed: ' . $e->getMessage());
            throw new Exception('Order update failed: ' . $e->getMessage());
        }
    }

    /**
     * Delete an order and detach items
     */
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $order = $this->orderRepository->find($id);

            if ($order) {
                $order->items()->detach();
                $this->orderRepository->delete($id);
            }

            DB::commit();
            return true;

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Order deletion failed: ' . $e->getMessage());
            throw new Exception('Order deletion failed: ' . $e->getMessage());
        }
    }
}