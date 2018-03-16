<?php
trait MasterTableTrait
{
    protected function replaceRecords($table, $array)
    {
        $template = "INSERT INTO %s (%s) VALUES (%s) ON DUPLICATE KEY UPDATE %s";
        foreach ($array as $attributes) {
            $attrs = [];
            $placeholders = [];
            $values = [];
            foreach ($attributes as $attr => $value) {
                $attrs[] = $attr;
                $placeholders[] = '?';
                $values[] = $value;
            }
            $sql = sprintf($template, $table, implode(", ", $attrs), implode(", ", $placeholders),
                implode(", ", array_map(function($a) { return sprintf("%s = VALUES(%s)", $a, $a); }, array_diff($attrs, ['id', 'created_at']))));
            DB::statement($sql, $values);
        }
    }
    protected function insertIgnoreRecords($table, $array)
    {
        $template = "INSERT IGNORE INTO %s (%s) VALUES (%s)";
        foreach ($array as $attributes) {
            $attrs = [];
            $placeholders = [];
            $values = [];
            foreach ($attributes as $attr => $value) {
                $attrs[] = $attr;
                $placeholders[] = '?';
                $values[] = $value;
            }
            $sql = sprintf($template, $table, implode(", ", $attrs), implode(", ", $placeholders));
            DB::statement($sql, $values);
        }
    }
}