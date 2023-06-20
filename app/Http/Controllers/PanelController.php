<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Node;
use App\Models\NodeData;

class PanelController extends Controller{
    // 
    // - Panel Index
    // 

    public function index(){
        return view("panel.index")->with([
            "root_nodes" => auth()->user()->nodes()->where("parent_id", 0)->get(),
        ]);
    }

    public function node_index($node){
        if(
            ($node = Node::find($node)) &&
            $node->user_id == auth()->user()->id
        ){
            return view("panel.node_index")->with([
                "node" => $node,
            ]);
        }

        return abort(404);
    }

    // 
    // - Add a Node
    // 

    public function add_node(Request $request){
        $request->validate([
            "parent" => "integer|required",
            "label" => "required",
        ]);

        $node = new Node;
        $node->user_id = auth()->user()->id;
        $node->parent_id = $request->parent;
        $node->label = $request->label;
        $node->save();

        if($request->content){
            $node_data = new NodeData;
            $node_data->node_id = $node->id;
            $node_data->type = 0;
            $node_data->content = $request->content;
            $node_data->save();
        }

        return response()->json([
            "success" => true,
            "id" => $node->id,
        ]);
    }

    // 
    // - Edit a Node
    // 

    public function edit_node($node, Request $request){
        $request->validate([
            "label" => "required",
        ]);


        if(!($n = Node::find($node)) || ($n->user_id != auth()->user()->id)){
            abort(404);
        }

        $n->label = $request->label;
        $n->save();

        if($request->content){
            $n->data()->delete();
            $node_data = new NodeData;
            $node_data->node_id = $n->id;
            $node_data->type = 0;
            $node_data->content = $request->content;
            $node_data->save();
        }

        return response()->json([
            "success" => true,
        ]);
    }


    // 
    // - Delete a Node
    // 

    public function del_node($node){
        if(($n = Node::find($node)) && ($n->user_id == auth()->user()->id)){
            $n->good_delete();
        }

        return response()->json([
            "success" => 1,
        ]);
    }

    // 
    // - View a Node
    // 

    public function node($node){
        $nodes = [];

        foreach(Node::where('parent_id', $node)->get() ?? [] as $n){
            $nodes []= [
                "id" => $n->id,
                "label" => $n->label,
                // "content" => $this->gen_node_content($n),
                "children" => $this->get_node_children($n),
                "active" => true,
            ];
        }

        return response()->json([
            "success" => 1,
            "target" => $node,
            "nodes" => $nodes,
        ]);
    }

    public function node_content($node){
        $nodes = [];
        if($n = Node::find($node))
            return response()->json([
                "success" => 1,
                "content" => nl2br(htmlspecialchars($this->gen_node_content($n))),
            ]);

        return abort(404);
    }



    // 
    // - Help Page
    // 

    public function info(){
        return view("panel.info");
    }


    private function gen_node_content($node){
        $content = "";
        foreach($node->data()->get() as $d){
            $content .= $d->content;
            $content .= "\n";
        }
        return $content;
    }

    private function get_node_children($node){
        $children = [];

        foreach($node->children() as $ch){
            $children []= [$ch->id, $ch->label];
        }

        return $children;
    }
}
