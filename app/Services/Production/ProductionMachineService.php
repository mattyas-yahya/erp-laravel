<?php

namespace App\Services\Production;

use App\Http\Requests\ProductionMachineRequest;
use App\Repositories\Production\ProductionMachineEloquentRepository;

class ProductionMachineService
{
    protected $machineRepo;

    public function __construct(
        ProductionMachineEloquentRepository $machineRepo,
    )
    {
        $this->machineRepo = $machineRepo;
    }

    public function getMachines()
    {
        return $this->machineRepo->all();
    }

    public function findMachine($id)
    {
        return $this->machineRepo->find($id);
    }

    public function createMachine(ProductionMachineRequest $request)
    {
        return $this->machineRepo->create($request);
    }

    public function updateMachine(ProductionMachineRequest $request, $id)
    {
        return $this->machineRepo->update($request, $id);
    }

    public function deleteMachine(string $id)
    {
        $machine = $this->machineRepo->find($id);

        if ($machine) {
            return $this->machineRepo->delete($id);
        }

        return 0;
    }
}
