## nested demo

>https://blog.csdn.net/laoyang360/article/details/82950393



```json
{
  "article_index_test1": {
    "mappings": {
      "article": {
        "dynamic": "false",
        "_all": {
          "enabled": false
        },
        "properties": {
          "article_id": {
            "type": "integer",
            "ignore_malformed": true
          },
          "article_res_card": {
            "type": "nested",
            "properties": {
              "common_keyword": {
                "type": "keyword",
                "ignore_above": 256
              },
              "data_type": {
                "type": "keyword",
                "ignore_above": 256
              },
              "title_ansj": {
                "type": "text",
                "similarity": "zdm_bm25",
                "analyzer": "index_ansj",
                "search_analyzer": "query_ansj"
              },
              "title_ik": {
                "type": "text",
                "similarity": "zdm_bm25",
                "analyzer": "ik_max_word"
              },
              "url": {
                "type": "keyword",
                "ignore_above": 256
              },
              "url_md5": {
                "type": "keyword",
                "ignore_above": 256
              },
              "wiki_id": {
                "type": "keyword",
                "ignore_above": 256
              },
              "wiki_url": {
                "type": "keyword",
                "ignore_above": 256
              }
            }
          },
          "article_res_card_titles": {
            "type": "keyword",
            "fields": {
              "keyword_ansj": {
                "type": "text",
                "similarity": "zdm_bm25",
                "analyzer": "index_ansj",
                "search_analyzer": "query_ansj"
              },
              "keyword_ik": {
                "type": "text",
                "similarity": "zdm_bm25",
                "analyzer": "ik_max_word"
              }
            },
            "ignore_above": 256
          }
        }
      }
    }
  }
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