<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Node extends Model{
    public $_children = [];
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function data(){
        return $this->hasMany(NodeData::class, 'node_id');
    }

    public function children_nodes(){
        return $this->hasMany(Node::class, 'parent_id');
    }

    public function parent(){
        return $this->belongsTo(Node::class, 'parent_id');
    }

    public function children(){
        return $this->_children = $this->children_nodes()->get();
    }

    // Prune Recusrively
    public function good_delete(){
        foreach($this->children() as $ch){
            $ch->good_delete();
            $ch->delete();
        }
        $this->delete();
    }
}
