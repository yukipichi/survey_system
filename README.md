# survey_system📝
システムへのアンケートを記入してもらい、どのような性別、年代のアンケートが集まったか調査するシステムです。
一部自身で変更を行いましたが、noteのlaravelチュートリアルを参考にしました。

参考にした記事
-【Laravel 道場】仕様書から作る実践型課題
https://note.com/yuppymam/n/ne461180705be

## 1.主要技術

| 言語・フレームワーク | バージョン |
| -------------------- | ---------- |
| MySQL                | 8.0.32     |
| Laravel              | 11.37.0    |
| Docker               | 27.4.0     |


## 2.コマンド一覧

| コマンド                                               　| 実行する処理                         |
| ------------------------------------------------------ | ------------------------------------|
| docker-compose up -d                                   | Docker の 起動                       |
| docker compose exec -it survey_system-app-1 bash       | Docker コンテナに入る 　　　　　　　　　 |
| docker-compose down                                    | Docker の停止                        |  


## 3.アンケート機能
アンケート機能では主にBootStrapTableを用いていますが、JavaScriptと組み合わせてアンケートの一覧のデータを
非同期(Ajax)で表示・操作できるようにしました。

<img width="1345" alt="Image" src="https://github.com/user-attachments/assets/f3190406-dcf2-43d6-96be-4303c02268a4" />

<img width="1404" alt="Image" src="https://github.com/user-attachments/assets/9fe27b88-8335-46f2-858e-af8e9c3646db" />