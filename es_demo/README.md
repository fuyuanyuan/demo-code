## nested demo

>https://blog.csdn.net/laoyang360/article/details/82950393



```json
{
  "query": {
    "bool": {
      "must": [
        {
          "bool": {
            "should": [
              {
                "query_string": {
                  "query": "小米",
                  "fields": [
                    "article_title.ik",
                    "article_title.ansj"
                  ],
                  "analyzer": "query_ansj",
                  "default_operator": "and"
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "query_string": {
                      "query": "小米",
                      "fields": [
                        "seo_tdk_field.keyword_ik",
                        "seo_tdk_field.keyword_ansj"
                      ],
                      "analyzer": "query_ansj",
                      "default_operator": "and"
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "match_phrase": {
                      "article_card_title_list.keyword_ik": {
                        "query": "小米",
                        "analyzer": "query_ansj",
                        "slop": 99
                      }
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "match_phrase": {
                      "article_card_title_list.keyword_ansj": {
                        "query": "小米",
                        "analyzer": "query_ansj",
                        "slop": 99
                      }
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "article_card_common_keyword": [
                        "小米"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "article_tag_names": [
                        "小米"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "mall_info.name_cn": [
                        "小米"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "mall_info.name_en": [
                        "小米"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "brand_info.cn_title": [
                        "小米"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "brand_info.en_title": [
                        "小米"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "brand_info.common_title": [
                        "小米"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "brand_info.associate_title": [
                        "小米"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "category_info.title": [
                        "小米"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "category_info.search_nicktitle": [
                        "小米"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "article_category_names": [
                        "小米"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "search_common_keyword": [
                        "小米"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "query_string": {
                      "query": "小米",
                      "fields": [
                        "origin_title.ik",
                        "origin_title.ansj"
                      ],
                      "analyzer": "query_ansj",
                      "default_operator": "and"
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "wiki_brand_names": [
                        "小米"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "wiki_aliases_names": [
                        "小米"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "wiki_category_names": [
                        "小米"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "query_string": {
                      "query": "小米",
                      "fields": [
                        "wiki_names.ik",
                        "wiki_names.ansj"
                      ],
                      "analyzer": "query_ansj",
                      "default_operator": "and"
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "query_string": {
                      "query": "小米",
                      "fields": [
                        "fav_price.keyword_ik",
                        "fav_price.keyword_ansj"
                      ],
                      "analyzer": "query_ansj",
                      "default_operator": "and"
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "query_string": {
                      "query": "小米",
                      "fields": [
                        "homepage_title.ik",
                        "homepage_title.ansj"
                      ],
                      "analyzer": "query_ansj",
                      "default_operator": "and"
                    }
                  },
                  "boost": 1
                }
              },
              {
                "query_string": {
                  "query": "xiaomi",
                  "fields": [
                    "article_title.ik",
                    "article_title.ansj"
                  ],
                  "analyzer": "query_ansj",
                  "default_operator": "and"
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "query_string": {
                      "query": "xiaomi",
                      "fields": [
                        "seo_tdk_field.keyword_ik",
                        "seo_tdk_field.keyword_ansj"
                      ],
                      "analyzer": "query_ansj",
                      "default_operator": "and"
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "match_phrase": {
                      "article_card_title_list.keyword_ik": {
                        "query": "xiaomi",
                        "analyzer": "query_ansj",
                        "slop": 99
                      }
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "match_phrase": {
                      "article_card_title_list.keyword_ansj": {
                        "query": "xiaomi",
                        "analyzer": "query_ansj",
                        "slop": 99
                      }
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "article_card_common_keyword": [
                        "xiaomi"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "article_tag_names": [
                        "xiaomi"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "mall_info.name_cn": [
                        "xiaomi"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "mall_info.name_en": [
                        "xiaomi"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "brand_info.cn_title": [
                        "xiaomi"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "brand_info.en_title": [
                        "xiaomi"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "brand_info.common_title": [
                        "xiaomi"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "brand_info.associate_title": [
                        "xiaomi"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "category_info.title": [
                        "xiaomi"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "category_info.search_nicktitle": [
                        "xiaomi"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "article_category_names": [
                        "xiaomi"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "search_common_keyword": [
                        "xiaomi"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "query_string": {
                      "query": "xiaomi",
                      "fields": [
                        "origin_title.ik",
                        "origin_title.ansj"
                      ],
                      "analyzer": "query_ansj",
                      "default_operator": "and"
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "wiki_brand_names": [
                        "xiaomi"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "wiki_aliases_names": [
                        "xiaomi"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "terms": {
                      "wiki_category_names": [
                        "xiaomi"
                      ]
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "query_string": {
                      "query": "xiaomi",
                      "fields": [
                        "wiki_names.ik",
                        "wiki_names.ansj"
                      ],
                      "analyzer": "query_ansj",
                      "default_operator": "and"
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "query_string": {
                      "query": "xiaomi",
                      "fields": [
                        "fav_price.keyword_ik",
                        "fav_price.keyword_ansj"
                      ],
                      "analyzer": "query_ansj",
                      "default_operator": "and"
                    }
                  },
                  "boost": 1
                }
              },
              {
                "constant_score": {
                  "filter": {
                    "query_string": {
                      "query": "xiaomi",
                      "fields": [
                        "homepage_title.ik",
                        "homepage_title.ansj"
                      ],
                      "analyzer": "query_ansj",
                      "default_operator": "and"
                    }
                  },
                  "boost": 1
                }
              }
            ]
          }
        },
        {
          "bool": {
            "filter": [
              {
                "terms": {
                  "article_type": [
                    "haowubang",
                    "zhongce_product",
                    "coupon",
                    "zhongce",
                    "wiki_product",
                    "zhuanti",
                    "shai",
                    "haitao",
                    "finder",
                    "pinpai_zhuanti",
                    "faxian",
                    "youhui",
                    "yuanchuang",
                    "newbrand",
                    "news",
                    "video"
                  ]
                }
              },
              {
                "terms": {
                  "is_review": [
                    0,
                    1,
                    2
                  ]
                }
              }
            ],
            "must_not": [
              {
                "terms": {
                  "article_category_ids": [
                    4811
                  ]
                }
              }
            ]
          }
        }
      ]
    }
  },
  "sort": [
    {
      "article_publish_time": {
        "order": "desc"
      }
    }
  ],
  "from": 0,
  "size": 20
}
```


## 查询语句


### 数组类型 查询会跨行匹配
```json

{
  "query": {
    "bool": {
      "must": [
        {
          "query_string": {
            "query": "咖啡家居",
            "fields": [
              "article_res_card_titles.keyword_ansj",
              "article_res_card_titles.keyword_ik"
            ],
            "analyzer": "query_ansj",
            "default_operator": "and"
          }
        }
      ]
    }
  }
}

```

### 解决跨行匹配额方法

1. nested类型查询
```json

{
  "query": {
    "bool": {
      "must": [
        {
          "nested": {
            "path": "article_res_card",
            "query": {
              "bool": {
                "must": [
                  {
                    "query_string": {
                      "query": "电脑",
                      "fields": [
                        "article_res_card.title_ansj",
                        "article_res_card.title_ik"
                      ],
                      "analyzer": "query_ansj",
                      "default_operator": "and"
                    }
                  }
                ]
              }
            }
          }
        }
      ]
    }
  }
}

```

还能用multi_match查询
```json
{
  "query": {
    "bool": {
      "must": [
        {
          "nested": {
            "path": "article_res_card",
            "query": {
              "bool": {
                "must": [
                  {
                    "multi_match": {
                      "fields": [
                        "article_res_card.title_ansj",
                        "article_res_card.title_ansj"
                      ],
                      "query": "咖啡家居",
                      "operator": "and",
                      "type": "best_fields",
                      "analyzer": "query_ansj",
                      "boost": 1
                    }
                  }
                ]
              }
            }
          }
        }
      ]
    }
  }
}
```
>https://www.elastic.co/guide/cn/elasticsearch/guide/current/nested-objects.html



2.用短语匹配方法查询

```json
{
  "query": {
    "bool": {
      "must": [
        {
          "match_phrase": {
            "article_res_card_titles.keyword_ansj": {
              "query": "咖啡",
              "analyzer": "query_ansj",
              "slop": 99
            }
          }
        }
      ]
    }
  }
}
```

>https://elasticsearch.cn/book/elasticsearch_definitive_guide_2.x/phrase-matching.html

>https://elasticsearch.cn/book/elasticsearch_definitive_guide_2.x/_multivalue_fields_2.html

>https://www.elastic.co/guide/en/elasticsearch/reference/5.4/position-increment-gap.html