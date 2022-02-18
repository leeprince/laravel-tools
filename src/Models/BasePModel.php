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
    public static function firstP(array $where, array $columns = ['*'], bool $ignoreDeleted = false, bool $isDeleted = false): array
    {
        self::autoDeletedAtField($where, $ignoreDeleted, $isDeleted);
        $data = static::query()->where($where)->first($columns);
        if (empty($data)) {
            return [];
        }
        
        return $data->toArray();
    }
    
    /**
     * 获取多行数据
     *
     * @param array $where
     * @param array $columns
     * @param array $whereInKeyToValue
     * @param string $orderByRaw
     * @param string $groupByRaw
     * @param int $offset
     * @param int $limit
     * @param bool $ignoreDeleted
     * @param bool $isDeleted
     * @return array
     */
    public static function getP(
        array $where,
        array $columns = ['*'],
        array $whereInKeyToValue = [],
        string $orderByRaw = "",
        string $groupByRaw = "",
        int $offset = 0,
        int $limit = 0,
        bool $ignoreDeleted = false,
        bool $isDeleted = false
    ): array
    {
        self::autoDeletedAtField($where, $ignoreDeleted, $isDeleted);
        $builder = static::query()->select($columns)->where($where);
        if (!empty($whereInKeyToValue)) {
            foreach ($whereInKeyToValue as $field => $value) {
                $builder = $builder->whereIn($field, $value);
            }
        }
        if (!empty($groupByRaw)) {
            $builder = $builder->groupByRaw($groupByRaw);
        }
        if (!empty($orderByRaw)) {
            $builder = $builder->orderByRaw($orderByRaw);
        }
        if ($offset >= 0 && $limit > 0) {
            $builder = $builder->skip($offset)->take($limit);
        }
        $data = $builder->get();
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
    public static function countP(
        array $where,
        string $columns = "*",
        string $groupByRaw = "",
        bool $ignoreDeleted = false,
        bool $isDeleted = false
    ): int
    {
        self::autoDeletedAtField($where, $ignoreDeleted, $isDeleted);
        $builder = static::query()->where($where);
        if (!empty($groupByRaw)) {
            $builder = $builder->groupByRaw($groupByRaw);
        }
        $count = $builder->count($columns);
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
     * @param bool $autoTimeField
     * @return int
     */
    public static function insertGetIdP(array $data, bool $autoTimeField = true): int
    {
        self::autoCreateAtAndUpdatedAtField($data, $autoTimeField);
        return static::query()->insertGetId($data);
    }
    
    /**
     * 添加信息
     *
     * @param array $where
     * @param array $data
     * @param bool $autoTimeField
     * @return int
     */
    public static function updateP(array $where, array $data, bool $autoTimeField = true): int
    {
        self::autoCreateAtAndUpdatedAtField($data, $autoTimeField, true);
        return static::query()->where($where)->update($data);
    }
    
    /**
     * 存在更新；不存在则插入
     *  created_at、updated_at 字段 Illuminate\Database\Query 不维护，需自己维护
     *
     * @param array $where
     * @param array $data
     * @return int
     */
    public static function updateOrInsertP(array $attributes, array $values = [])
    {
        return static::query()->updateOrInsert($attributes, $values);
    }
    
    /**
     * 存在更新；不存在则插入
     *  created_at、updated_at 字段 Illuminate\Database\Eloquent 维护
     *
     * @param array $where
     * @param array $data
     * @return int
     */
    public static function updateOrCreateP(array $attributes, array $values = [])
    {
        return static::query()->updateOrCreate($attributes, $values);
    }
    
    /**
     * 自动检查并添加 created_at、updated_at 字段
     *
     * @param array $data
     * @param bool $autoTimeField
     */
    private static function autoCreateAtAndUpdatedAtField(array &$data, bool $autoTimeField, bool $isUpdate = false)
    {
        if ($autoTimeField) {
            $ctime = time();
            if (!$isUpdate && (!isset($data['created_at']) || empty($data['created_at']))) {
                $data['created_at'] = $ctime;
            }
            if (!isset($data['updated_at']) || empty($data['updated_at'])) {
                $data['updated_at'] = $ctime;
            }
        }
    }
    
    /**
     * 自动检查并添加 deleted_at 字段
     *
     * @param array $where
     * @param bool $ignoreDeleted 是否忽略 deleted_at 字段，忽略则不再检查 $isDeleted
     * @param bool $isDeleted $ignoreDeleted = false 情况下，判断并添加 deleted_at 字段;true: 返回删除的数据；false:返回未删除的数据
     */
    private static function autoDeletedAtField(array &$where, bool $ignoreDeleted, bool $isDeleted)
    {
        // 存在 deleted_at 字段不再检查
        if (isset($where['deleted_at'])) {
            return;
        }
        
        // 忽略 deleted_at 字段则不继续检查
        if ($ignoreDeleted) {
            return;
        }
        
        if ($isDeleted) {
            array_push($where, ['deleted_at', '!=', 0]);
        } else {
            // 两种都可以
            // $where = array_merge($where, ['deleted_at' => 0]);
            array_push($where, ['deleted_at', '=', 0]);
        }
    }
}