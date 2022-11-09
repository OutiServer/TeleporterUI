# TeleporterUI

使い方：

このプラグインを導入してサーバーを起動すると`plugin_data`に`Teleporter`というディレクトリが作成されるのでそこに`teleporter_map.yml`を追加してください。
そして`/teleportui`コマンドを実行するとUIが出て、アイテムを選択するとテレポートが出来ます。

`teleporter_map.yml`のサンプル

```yml
map:
  - item1: #item1,item2,item3とあるがその変数名は変更しても大丈夫なやつ
        displayname: おうち中央駅前 #表示名
        pos: #テレポート先の座標
            - 51
            - 65
            - -98
  - item2:
        displayname: おうち中央駅前2
        pos:
            - 53
            - 65
            - -24
  - item3:
      displayname: おうち鯖駅内
      map: #子アイテム。これを選択するとchilditem1が出る
        - childitem1:
            displayname: 地図前
            pos:
                - 63
                - 77
                - -38
```
**フォーマットを間違えるとエラーが出ます。**
