<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . '/controllers/cli_base.php';
class Cli_article_test extends Cli_base
{
    function init()
    {
        // TODO: Implement init() method.
        $this->load->library('service_es', ['type' => 'zdm_article']);
        parent::cron_manager();
    }

    /**
     * @desc 创建索引
     * php index.php article cli_article_test create_index
     */
    function create_index($type = 'zdm_article')
    {
        $this->load->library('service_es', ['type' => $type], 'es_lib');
        $this->load->config('es_conf/article_index_test');
        $index_conf = $this->config->item('index_structure');
        $ret = $this->es_lib->createIndex($index_conf);
        if (!empty($ret['data']['acknowledged']) && $ret['data']['acknowledged']) {
            echo "index " . Config::$article_index_settings['index_alias'] . " success";
        } else {
            echo "index " . Config::$article_index_settings['index_alias'] . " error" . print_r($ret, true);
        }
    }

    /**
     * @desc 创建索引
     * php index.php article cli_article_test input_data
     */
    function input_data()
    {
        $this->load->library('service_es', ['type' => 'zdm_article']);

        $es_data = [];
        $es_data['index'] = 'article_index_test1';
        $es_data['type']  = 'article';

        $es_data['body'][] = [
            'index' => [
                '_id' => 1
            ]
        ];
        $es_data['body'][] = [
            'article_id' => 1,
            'article_res_card' => [
                [
                    'title_ansj' => '鸿星尔克(erke)男鞋运动鞋男新品透气气垫鞋网布跑步鞋系带减震半掌休闲男鞋 正黑0066（革面） 42',
                    'title_ik' => '鸿星尔克(erke)男鞋运动鞋男新品透气气垫鞋网布跑步鞋系带减震半掌休闲男鞋 正黑0066（革面） 42',
                    'data_type' => '1',
                    'wiki_id' => '0',
                    'url' => 'https://item.jd.com/34302923624.html',
                ],
                [
                    'title_ansj' => 'la mer 海蓝之谜 洗面奶',
                    'title_ik' => 'la mer 海蓝之谜 洗面奶',
                    'data_type' => '2',
                    'wiki_id' => '25023959',
                    'wiki_url' => 'http://wiki.smzdm.com/p/yeer5xw',
                    'url' => 'https://item.jd.com/28553617919.html',
                    'common_keyword' => [
                        "个护化妆",
                        "面部护理",
                        "清洁产品",
                        "洁面乳",
                    ]
                ],
            ],
            'article_res_card_titles'=>[
                '鸿星尔克(erke)男鞋运动鞋男新品透气气垫鞋网布跑步鞋系带减震半掌休闲男鞋 正黑0066（革面） 42',
                'la mer 海蓝之谜 洗面奶',
            ]

        ];
        $es_data['body'][] = [
            'index' => [
                '_id' => 2
            ]
        ];
        $es_data['body'][] = [
            'article_id' => 2,
            'article_res_card' => [
                [
                    'title_ansj' => '鸿星尔克(erke)运动鞋男缓震型跑鞋 2019春季新款男鞋时尚潮流缓震轻便跑步鞋休闲鞋 正黑/金泊色 42',
                    'title_ik' => '鸿星尔克(erke)运动鞋男缓震型跑鞋 2019春季新款男鞋时尚潮流缓震轻便跑步鞋休闲鞋 正黑/金泊色 42',
                    'data_type' => '1',
                    'wiki_id' => '0',
                    'url' => 'https://item.jd.com/40343795938.html',
                ],
                [
                    'title_ansj' => 'POUILLY LEGENDE 布衣传说 雷军 (20ml)',
                    'title_ik' => 'POUILLY LEGENDE 布衣传说 雷军 (20ml)',
                    'data_type' => '2',
                    'wiki_id' => '25002821',
                    'wiki_url' => 'http://wiki.smzdm.com/p/xmm780p',
                    'url' => 'https://detail.tmall.com/item.htm?id=567610938792',
                    'common_keyword' => [
                        "母婴用品",
                        "洗护用品",
                        "宝宝护肤",
                        "婴儿洁面乳",
                    ]
                ],
            ],
            'article_res_card_titles'=>[
                '鸿星尔克(erke)运动鞋男缓震型跑鞋 2019春季新款男鞋时尚潮流缓震轻便跑步鞋休闲鞋 正黑/金泊色 42',
                'POUILLY LEGENDE 布衣传说 雷军 (20ml)',
            ]

        ];



        $es_data['body'][] = [
            'index' => [
                '_id' => 3
            ]
        ];
        $es_data['body'][] = [
            'article_id' => 3,
            'article_res_card' => [
                [
                    'title_ansj' => '中亚Prime会员：Delonghi 德龙 EDG 355.b1 Dolce Gusto Colors 胶囊咖啡机',
                    'title_ik' => '中亚Prime会员：Delonghi 德龙 EDG 355.b1 Dolce Gusto Colors 胶囊咖啡机',
                ],
                [
                    'title_ansj' => '促销活动：亚马逊中国 家居618提前购',
                    'title_ik' => '促销活动：亚马逊中国 家居618提前购',
                ],
            ],
            'article_res_card_titles'=>[
                '中亚Prime会员：Delonghi 德龙 EDG 355.b1 Dolce Gusto Colors 胶囊咖啡机',
                '促销活动：亚马逊中国 家居618提前购',
            ]

        ];

        $es_data['body'][] = [
            'index' => [
                '_id' => 4
            ]
        ];
        $es_data['body'][] = [
            'article_id' => 4,
            'article_res_card' => [
                [
                    'title_ansj' => '10日0点：DELL 戴尔 P2418D 23.8英寸 IPS显示器（2560×1440）',
                    'title_ik' => '10日0点：DELL 戴尔 P2418D 23.8英寸 IPS显示器（2560×1440）',
                ],
                [
                    'title_ansj' => '10日0点：RAYTINE 雷霆世纪 The fire II 台式电脑主机（i5-8500、GTX 1070Ti、8GB、128GB）',
                    'title_ik' => '10日0点：RAYTINE 雷霆世纪 The fire II 台式电脑主机（i5-8500、GTX 1070Ti、8GB、128GB）',
                ],
            ],
            'article_res_card_titles'=>[
                '10日0点：RAYTINE 雷霆世纪 The fire II 台式电脑主机（i5-8500、GTX 1070Ti、8GB、128GB）',
                '10日0点：DELL 戴尔 P2418D 23.8英寸 IPS显示器（2560×1440）',
            ]

        ];

        $es_res = $this->service_es->bulk($es_data);
        var_dump($es_res);exit;

    }
}