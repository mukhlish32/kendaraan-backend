<?php
namespace App\Repositories;

// use App\Models\Kendaraan;
use App\Helpers\MongoModel;

class KendaraanRepository
{
	private MongoModel $tasks;
	public function __construct()
	{
		$this->tasks = new MongoModel('kendaraan');
	}
	public function getAll()
	{
		$tasks = $this->tasks->get([]);
		return $tasks;
	}

	public function getById(string $id)
	{
		$task = $this->tasks->find(['_id'=>$id]);
		return $task;
	}

	public function create(array $data)
	{
		$data = [
			'merk'=>$data['merk'],
			'tahun_release'=>$data['tahun_release'],
			'mobil'=> [],
			'created_at'=>time()
		];

		$id = $this->tasks->save($data);
		return $id;
	}

	public function save(array $editedData)
	{
		$id = $this->tasks->save($editedData);
		return $id;
	}

	public function delete($id)
	{
		$task = $this->tasks->deleteQuery(['_id'=>$id]);
	}
}