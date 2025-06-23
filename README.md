# survey_system📝
システムへのアンケートを記入し、どのような性別、年代のアンケートが集まったか調査するシステムです。
一部自身で変更を行いましたが、noteのlaravelチュートリアルを参考にしました。

参考にした記事
-【Laravel 道場】仕様書から作る実践型課題

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
| docker-compose down                                    | Docker の停止                        |  

## アンケート機能
チュートリアルでは、主にBootStrapTable用いていますが、JavaScriptと組み合わせてアンケートの一覧のデータを
非同期(Ajax)で表示・操作できるようにしました。

<img width="1404" alt="Image" src="https://github.com/user-attachments/assets/9fe27b88-8335-46f2-858e-af8e9c3646db" />