<?php
/**
 * Created by Green Studio.
 * File: TagsLogic.class.php
 * User: TianShuo
 * Date: 14-1-16
 * Time: 上午12:37
 */

namespace Common\Logic;
use Think\Model\RelationModel;

/**
 * Class TagsLogic
 * @package Home\Logic
 */
class TagsLogic extends RelationModel
{


    public function detail($id, $relation = true)
    {
        $map = array();
        $map['tag_id|tag_slug'] = $id;
        return D('Tags')->where($map)->relation($relation)->find();
    }

    /**
     * @param $info 输入tag_id|tag_slug
     *
     * @return mixed 找到的话返回post_id数组集合
     */
    public function getPostsId($info)
    {
        $tag_info ['tag_id'] = $info;
        $tag = D('Post_tag')->field('post_id')->where($tag_info)->select();
        foreach ($tag as $key => $value) {
            $tag[$key] = $tag[$key]['post_id'];
        }
        return $tag;
    }

    /**
     * @param $cat_id 分类id
     * @param int $num 数量
     *
     * @return mixed
     */
    public function getPostsByTag($tag_id, $num = 5)
    {
        $tag = $this->getPostsId($tag_id);
        $posts = D('Posts', 'Logic')->getList($num, 'single', 'post_id desc', true, array(), $tag);
        return $posts;
    }

    /**
     * @param int $limit
     * @param bool $relation
     *
     * @return mixed
     */
    public function getList($limit = 20, $relation = true)
    {
        return D('Tags')->limit($limit)->relation($relation)->select();
    }






}