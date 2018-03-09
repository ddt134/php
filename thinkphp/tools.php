<?php
class CommonModel extends Model
{
    public function save($data)
    {
        $pk = $this->getPk();
        if(empty($data[$pk])) {
            $data['create_time']=time();
            $id=$this->add($data);
            return $id;
        } else {
            $data['update_time']=time();
            parent::save($data);
            return $pk;
        }
    }

    public function multiUpdate($data){
        $pk = $this->getPk();
        $ids=array_column($data,$pk);
        $sql="update ".$this->getTableName()." set ";
        foreach($data[0] as $k=>$v){
            if($k==$pk){
                continue;
            }
            $sql.=" $k= case $pk ";
            foreach($data as $key=>$value){
                $sql.=" when '{$value[$pk]}' then '{$value[$k]}'";
            }
            $sql.=" end,";
        }
        $sql=rtrim($sql,',')." where $pk in ('".implode("','",$ids)."')";
        $this->execute($sql);
    }
}