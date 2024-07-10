<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class SidebarController extends Controller
{
    protected $data;
    public function __construct(){
        $this->data = json_decode(Storage::get('public/files/sidebarAdmin.json'), true);
    }

    public static function sidebar($folder){
        return (new SidebarController())->build($folder);
    }

    public function build($folder){
        $html = '';
        foreach($this->data as $value){
            if(isset($value['root']) && $value['root'] < \Auth::user()->root){
            }else{
                $html .= $this->buildLi1($value, $folder);
            }
        }
        return $html;
    }

    protected function buildLi1($data, $folder){
        return `<li class="nav-item `.((isset($data['folder']) && isset($folder) && $data['folder'] == $folder)?'menu-open':'').`">
                    <a href="`.($data['link'] ?? '#').`" class="nav-link `.((isset($data['folder']) && isset($folder) && $data['folder'] == $folder)?'active':'').`">
                        <i class="nav-icon fas `.$data['icon'].`"></i>
                        <p>
                            `.$data['name'].
                            ((isset($data['items']) && is_array($data['items']) && count($data['items']) > 0)?'<i class="right fas fa-angle-left"></i>':'').`
                        </p>
                    </a>
                    `.((isset($data['items']) && is_array($data['items']) && count($data['items']) > 0)?$this->buildLi2($data['items']):'').`
                </li>`;
    }

    protected function buildLi2($data){
        return `<ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Level 2</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            Level 2
                            <i class="right fas fa-angle-left"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Level 3</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Level 3</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Level 3</p>
                            </a>
                        </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Level 2</p>
                        </a>
                    </li>
                </ul>`;
    }

    public function get(){
        return $this->data;
    }

    public function set(){

    }
}
