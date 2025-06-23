# survey_system📝
システムへのアンケートを記入し、どのような性別、年代のアンケートが集まったか調査するシステムです。
noteのlaravelチュートリアルを参考にしました。

こちらの記事
→
https://note.com/yuppymam/n/ne461180705be

## 2.主要技術

| 言語・フレームワーク | バージョン |
| -------------------- | ---------- |
| MySQL                | 8.0.32     |
| Laravel              | 11.37.0    |
| Docker               | 27.4.0     |


## 3.コマンド一覧

| コマンド                                               　| 実行する処理                         |
| ------------------------------------------------------ | ------------------------------------|
| docker-compose up -d                                   | Docker の 起動                       |
| docker compose exec -it survey_system-app-1 bash       | Docker コンテナに入る 　　　　　　　　　 |
| npm run dev                                            | フロントエンド起動　　　　　　　　　　　　 |
| docker-compose down                                    | Docker の停止                        |  
