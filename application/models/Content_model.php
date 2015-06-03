<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Content_model extends MY_Model
{
    private $featured_image;
    public function __construct()
    {
        $this->featured_image = $this->config->item('cms_featured_image');
        parent::__construct();
    }

    public function get_parents_list($content_type,$content_id = 0)
    {
        $this->db->select('id,short_title');
        $this->db->order_by('short_title','asc');
        $this->db->where('contents.id != ',$content_id);
        if($content_type == 'post')
        {
            $this->db->where('contents.content_type','category');
        }
        else
        {
            $this->db->where('contents.content_type',$content_type);
        }
        $query = $this->db->get('contents');
        $parents = array('0'=>'No parent');
        if($query->num_rows()>0)
        {
            foreach($query->result() as $row)
            {
                $parents[$row->id] = $row->short_title;
            }
        }
        return $parents;
    }

    public $rules = array(
        'insert' => array(
            'parent_id' => array('field'=>'parent_id','label'=>'Parent ID','rules'=>'trim|is_natural|required'),
            'title' => array('field'=>'title','label'=>'Title','rules'=>'trim|required'),
            'short_title' => array('field'=>'short_title','label'=>'Short title','rules'=>'trim'),
            'slug' => array('field'=>'slug', 'label'=>'Slug', 'rules'=>'trim'),
            'order' => array('field'=>'order','label'=>'Order','rules'=>'trim|is_natural'),
            'teaser' => array('field'=>'teaser','label'=>'Teaser','rules'=>'trim'),
            'content' => array('field'=>'content','label'=>'Content','rules'=>'trim'),
            'page_title' => array('field'=>'page_title','label'=>'Page title','rules'=>'trim'),
            'page_description' => array('field'=>'page_description','label'=>'Page description','rules'=>'trim'),
            'page_keywords' => array('field'=>'page_keywords','label'=>'Page keywords','rules'=>'trim'),
            'content_type' => array('field'=>'content_type','label'=>'Content type','rules'=>'trim|required'),
            'published_at' => array('field'=>'published_at','label'=>'Published at','rules'=>'trim|datetime')
        ),
        'update' => array(
            'parent_id' => array('field'=>'parent_id','label'=>'Parent ID','rules'=>'trim|is_natural|required'),
            'title' => array('field'=>'title','label'=>'Title','rules'=>'trim|required'),
            'short_title' => array('field'=>'short_title','label'=>'Short title','rules'=>'trim'),
            'slug' => array('field'=>'slug', 'label'=>'Slug', 'rules'=>'trim'),
            'order' => array('field'=>'order','label'=>'Order','rules'=>'trim|is_natural'),
            'teaser' => array('field'=>'teaser','label'=>'Teaser','rules'=>'trim'),
            'content' => array('field'=>'content','label'=>'Content','rules'=>'trim'),
            'page_title' => array('field'=>'page_title','label'=>'Page title','rules'=>'trim|required'),
            'page_description' => array('field'=>'page_description','label'=>'Page description','rules'=>'trim'),
            'page_keywords' => array('field'=>'page_keywords','label'=>'Page keywords','rules'=>'trim'),
            'content_id' => array('field'=>'content_id', 'label'=>'Content ID', 'rules'=>'trim|is_natural_no_zero|required'),
            'published_at' => array('field'=>'published_at','label'=>'Published at','rules'=>'trim|datetime')
        ),
        'insert_featured' => array(
            'file_name' => array('field'=>'file_name','label'=>'File name','rules'=>'trim'),
            'content_id' => array('field'=>'content_id','label'=>'Contend ID','rules'=>'tirm|is_natural_no_zero|required')
        )
    );
}