<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config = [
    'index_structure' => [
        'index' => 'article_index_test1',
        'body' => [
            'settings' => [
                'number_of_shards' => 12,
                'number_of_replicas' => 2,
                'refresh_interval' => '1s',
                'analysis' => [
                    'analyzer' => [
                        "first_py_letter_analyzer" => [
                            "tokenizer" => "first_py_letter",
                            "filter" => "edgeNGram_filter"
                        ],
                        "full_pinyin_letter_analyzer" => [
                            "tokenizer" => "full_pinyin_letter",
                            "filter" => "edgeNGram_filter"
                        ],
                        "edgeNGram_analyzer" => [
                            "tokenizer" => "edgeNGram_tokenizer"
                        ],
                    ],
                    'tokenizer' => [
                        "first_py_letter" => [
                            "type" => "pinyin",
                            "keep_first_letter" => true,
                            "keep_full_pinyin" => false,
                            "keep_original" => false,
                            "limit_first_letter_length" => 16,
                            "lowercase" => true,
                            "trim_whitespace" => true,
                            "keep_none_chinese_in_first_letter" => false,
                            "none_chinese_pinyin_tokenize" => false,
                            "keep_none_chinese" => true,
                            "keep_none_chinese_in_joined_full_pinyin" => true
                        ],
                        "full_pinyin_letter" => [
                            "type" => "pinyin",
                            "keep_separate_first_letter" => false,
                            "keep_full_pinyin" => false,
                            "keep_original" => false,
                            "limit_first_letter_length" => 16,
                            "lowercase" => true,
                            "keep_first_letter" => false,
                            "keep_none_chinese_in_first_letter" => false,
                            "none_chinese_pinyin_tokenize" => false,
                            "keep_none_chinese" => true,
                            "keep_joined_full_pinyin" => true,
                            "keep_none_chinese_in_joined_full_pinyin" => true
                        ],
                        "edgeNGram_tokenizer" => [
                            "type" => "edgeNGram",
                            "min_gram" => 1,
                            "max_gram" => 15,
                            "token_chars" => ["letter", "digit"]
                        ]
                    ],
                    "filter" => [
                        "edgeNGram_filter" => [
                            "type" => "edgeNGram",
                            "min_gram" => 1,
                            "max_gram" => 50,
                            "token_chars" => ["letter", "digit"]
                        ]
                    ]
                ],
                // 相似度.
                'similarity' => [
                    'zdm_bm25' => [
                        'type' => 'BM25',
                        'b' => 0.75,
                        'k1' => 1.2,
                        'discount_overlaps' => true
                    ]
                ],
            ],
            'mappings' => [
                'article' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    '_all' => [
                        'enabled' => FALSE,
                    ],
                    // 关闭自动添加字段
                    "dynamic" => FALSE,
                    'properties' => [
                        'article_id' => [
                            'type' => 'integer',
                            'ignore_malformed' => true, // 如果为真，则格式错误的数字将被忽略。 如果为false（默认），格式错误的数字会引发异常并拒绝整个文档。
                        ],
                        'article_res_card' => [
                            'type' => 'nested',
                            'properties' => [
                                'title_ansj' => [
                                    'search_analyzer' => 'query_ansj',
                                    'similarity' => 'zdm_bm25',
                                    'analyzer' => 'index_ansj',
                                    'type' => 'text'
                                ],
                                'title_ik' => [
                                    'similarity' => 'zdm_bm25',
                                    'analyzer' => 'ik_max_word',
                                    'type' => 'text'
                                ],
                                'data_type' => [
                                    'ignore_above' => 256,
                                    'type' => 'keyword',
                                ],
                                'wiki_id' => [
                                    'ignore_above' => 256,
                                    'type' => 'keyword',
                                ],
                                'wiki_url' => [
                                    'ignore_above' => 256,
                                    'type' => 'keyword',
                                ],
                                'url' => [
                                    'ignore_above' => 256,
                                    'type' => 'keyword',
                                ],
                                'url_md5' => [
                                    'ignore_above' => 256,
                                    'type' => 'keyword',
                                ],
                                'common_keyword' => [
                                    'ignore_above' => 256,
                                    'type' => 'keyword',
                                ],
                            ],
                        ],
                        'article_res_card_titles' => [
                            'type' => 'keyword',
                            'ignore_above' => 256,
                            'fields' => [
                                'keyword_ik' => [
                                    'type' => 'text',
                                    'analyzer' => 'ik_max_word',
                                    'search_analyzer' => 'ik_max_word',
                                    'similarity' => 'zdm_bm25'
                                ],
                                'keyword_ansj' => [
                                    'type' => 'text',
                                    'analyzer' => 'index_ansj',
                                    'search_analyzer' => 'query_ansj',
                                    'similarity' => 'zdm_bm25'
                                ]

                            ]
                        ]


                    ]
                ]
            ]
        ]
    ]
];