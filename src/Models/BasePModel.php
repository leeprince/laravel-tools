<?php
/**
 * 基础模型
 *
 * @Author leeprince:9/19/21 3:35 PM
 */

namespace Leeprince\LaravelTools\Models;


use Illuminate\Database\Eloquent\Model;

class BasePModel extends Model
{
    /**
     * 获取一行数据
     *
     * @param array $where
     * @param array $select
     * @return array
     */
    public static function firstP(array $where, array $columns = ['*'])
    {
        $data = static::query()->where($where)->first($columns);
        if (empty($data)) {
            return [];
        }
        return $data->toArray();
    }
    
    /**
     * 获取记录行数
     *
     * @param array $where
     * @param string $columns
     * @return int
     */
    public static function countP(array $where, string $columns = "*")
    {
        $count = static::query()->where($where)->count($columns);
        return $count;
    }
    
    /**
     * Eloquent：批量赋值;
     *  Eloquent 可以自动维护：created_at、updated_at 字段
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    public static function createP(array $data)
    {
        return static::query()->create($data);
    }
    
    /**
     * 添加信息
     *
     * @param array $data
     * @param bool $checkTimeField
     * @return int
     */
    public static function insertGetIdP(array $data, bool $checkTimeField = true)
    {
        self::checkTimeField($data, $checkTimeField);
        return static::query()->insertGetId($data);
    }
    
    /**
     * 添加信息
     *
     * @param array $data
     * @param bool $checkTimeField
     * @return int
     */
    public static function updateP(array $where, array $data, bool $checkTimeField = true)
    {
        self::checkTimeField($data, $checkTimeField);
        return static::query()->where($where)->update($data);
    }
    
    /**
     * 存在更新；不存在则插入
     *
     * @param array $where
     * @param array $data
     * @return bool
     */
    public static function updateOrInsertP(array $where, array $data)
    {
        return static::query()->updateOrInsert($where, $data);
    }
    
    /**
     * 检查 created_at、updated_at 字段
     *
     * @param array $data
     * @param bool $checkTimeField
     */
    private static function checkTimeField(array &$data, bool $checkTimeField)
    {
        if ($checkTimeField) {
            $ctime = time();
            if (!isset($data['created_at']) || empty($data['created_at'])) {
                $data['created_at'] = $ctime;
            }
            if (!isset($data['updated_at']) || empty($data['updated_at'])) {
                $data['updated_at'] = $ctime;
            }
        }
    }
}