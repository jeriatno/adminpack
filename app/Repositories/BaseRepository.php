<?php

namespace App\Repositories;

use App\Repositories\SupportTicket\SupportTicketModuleRepository;
use App\Traits\HasLogger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BaseRepository
{
    use HasLogger;

    public function getAll()
    {
        return $this->model->get();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function store($request)
    {
        return $this->model->create($request);
    }

    public function update($request, $id)
    {
        return $this->model->where('id', $id)->update($request);
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    /**
     * @param $request
     * @return \Exception|true
     */
    public function cancel($request)
    {
        $moduleType = get_class($this->model);
        $withStatus = $this->model->withStatus ?? true;
        $supportTicketModuleRepo = new SupportTicketModuleRepository();

        DB::beginTransaction();
        try {
            $data = $this->model->whereIn('id', $request->entries)->get();

            // fetch data checked
            foreach ($data as $value) {
                // save ticket id
                if(isset($request->ticket_id)) {
                    $saveTicket = $supportTicketModuleRepo->store($request->ticket_id, $moduleType, $value->id);
                    if(!$saveTicket) {
                        throw new \Exception('Ticket ID is not found!');
                    }
                }

                // update status
                if (Schema::hasColumn($this->model->getTable(), 'status') && $withStatus) {
                    $this->model->where('id', $value->id)->update([
                        'status'    => $moduleType::CANCELLED ?? 'cancelled',
                    ]);
                }

                // delete data
                $this->delete($value->id);
            }

            DB::commit();
            return true;
        } catch (\Exception $exception) {
            $moduleInstance = new $moduleType();

            $this->errorMessage($exception, $moduleInstance::app, __METHOD__, $request->entries);
            DB::rollBack();

            return $exception;
        }
    }

    /**
     * @param $request
     * @return array
     */
    public function stats($request)
    {
        return [
            'all' => $this->model->all()
        ];
    }

    /**
     * @return int[]
     */
    public function notify(): array
    {
        return [
            'notif_count' => 0
        ];
    }
}
