<?php

namespace app\models;


/**
 * Class TableModel 表格数据模型
 * @package app\models
 */
class TableModel extends BaseModel {
    /**
     * @var array 表格每行的数据
     */
    public $rows;
    /**
     * @var int 符合条件的数据条数
     */
    public $count;
    
    public function rules() {
        return [
            [["rows", "count"], "required"]
        ];
    }
    
    /**
     * 初始化一个实例
     * @param array $rows 表格每行的数据
     * @param int $count 符合条件的数据条数
     * @return TableModel
     */
    public static function newInstance($rows, $count){
        $tableModel = new TableModel();
        $tableModel->rows = $rows;
        $tableModel->count = $count;
        return $tableModel;
    }
}