<?php

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface
{
    public function getAll();
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
    public function getOrdersToSendToKitchen();
    public function updateStatus($orderId, $status);

}