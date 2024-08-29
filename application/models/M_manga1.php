<?php
// this scraping from https://ww8.mangakakalot.tv
require 'assets/simpledom/simple_html_dom.php';
class M_manga1 extends CI_Model

{

    public function homepage()
    {
        $base_url = base_url() . 'home/view_manga';
        $url = 'https://ww8.mangakakalot.tv';
        $html = file_get_html($url);
        $get_update = $html->find('div#contentstory div.doreamon div.itemupdate');
        $result = [];
        foreach ($get_update as $g) {
            $link = $g->find('a', 0)->href;
            $title = $g->find('ul li h3 a', 0)->plaintext;
            $row = [
                'link' =>  $link,
                'title' => $title
            ];
            $result[] = $row;
        }
        return $result;
    }

    public function get_detail($url)
    {
        $site = 'https://ww8.mangakakalot.tv';
        $main_url = 'https://ww8.mangakakalot.tv/' . $url;
        $html = file_get_html($main_url);
        $data_ch = [];

        $img = $html->find('div.manga-info-pic img', 0)->src;
        $title = $html->find('ul.manga-info-text li h1', 0)->plaintext;
        $alt_title = $html->find('ul.manga-info-text li h2.story-alternative', 0)->plaintext;
        $synopsis = $html->find('div#noidungm', 0)->plaintext;
        $chlist = $html->find('div.chapter-list div.row');

        foreach ($chlist as $ch) {
            $title_ch = $ch->find('span a', 0)->plaintext;
            $link_ch = $ch->find('span a', 0)->href;
            $update_at = $ch->find('span', 2)->plaintext;
            $row = [
                'title' => $title_ch,
                'link' => $link_ch,
                'update_at' => $update_at
            ];
            $data_ch[] = $row;
        }


        $result = [
            'img' => $site . $img,
            'title' => $title,
            'alt_title' => $alt_title,
            'synopsis' => $synopsis,
            'chapter' => $data_ch
        ];
        return $result;
    }

    public function get_chapter($url)
    {
        $site = 'https://ww8.mangakakalot.tv/' . $url;
        $html = file_get_html($site);

        $list_img = $html->find('div.vung-doc img');
        $title_ch = $html->find('div.info-top-chapter h2', 0)->plaintext;

        $prev_ch = $html->find('div.btn-navigation-chap a', 0)->href;
        $next_ch = $html->find('div.btn-navigation-chap a', 1)->href;

        $img_ch = [];
        foreach ($list_img as $img) {
            $image_ch = $img->attr['data-src'];
            $img_ch[] = $image_ch;
        }


        $result = [
            'title' => $title_ch,
            'prev' => $prev_ch,
            'next' => $next_ch,
            'image' => $img_ch
        ];
        return $result;
    }

    public function search($search)
    {
        $site = 'https://ww8.mangakakalot.tv/search/' . $search;
        $html = file_get_html($site);

        $list = $html->find('div.panel_story_list div.story_item');
        $datalist = [];
        foreach ($list as $l) {
            $title = $l->find('div.story_item_right h3.story_name a', 0)->plaintext;
            $link = $l->find('div.story_item_right h3.story_name a', 0)->href;

            $row = [
                'title' => $title,
                'link' => $link
            ];
            $datalist[] = $row;
        }

        $result = [
            'list' => $datalist
        ];

        return $result;
    }
}
