<?php

class Model 
{

}

interface ModelInterface 
{
    public function insert();
    public function read();
    public function update();
    public function delete();
}

class AssetModel extends Model implements ModelInterface 
{
    private $asset_id;
    private $asset_size;
    private $asset_path;
    private $asset_name;
    private $asset_status;
    private $asset_extension;

    public function __construct($data) {
        $this->asset_size = $data['asset_size'];
        $this->asset_path = $data['asset_path'];
        $this->asset_name = $data['asset_name'];
        $this->asset_status = $data['asset_status'];
        $this->asset_extension = $data['asset_extension'];
    }

    public function insert($data) {

    }
    public function read($data, $action) 
    {
        switch($action) 
        {
            case 'getOne':
                return Dispatcher::dispatch(
                    "SELECT * FROM asset WHERE asset_id = :asset_id",
                    $data,
                    ['fetchConstant' => 'fetch']
                );
                break;
            case 'getAll':
                break;
            case 'getAllByAccountId':
        }
    }
    public function update() {

    }
    public function delete() {

    }
}