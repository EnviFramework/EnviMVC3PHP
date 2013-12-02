[Envi PHP](http://www.enviphp.net/) - Light Weight PHP FlameWork
==================================================

Contribution Guides
--------------------------------------

オープンソースである、EnviMVCに貢献くださる方は、ガイドを読んでいただけると幸いです。

コードの修正や、バグの報告に関しては下記のリンクを参照してください。

1. [ソースコードのフォーク](https://github.com/EnviMVC/EnviMVC3PHP)
2. [マニュアル・wiki](https://github.com/EnviMVC/EnviMVC3PHP/wiki)
3. [バグ報告](https://github.com/EnviMVC/EnviMVC3PHP/issues)



コードの実行環境
--------------------------------------

PHP 5.2および、PHP 5.3が正常動作する環境での開発を行って下さい。
PHP5.2および、PHP5.3で互換を保つようにして下さい。
EnviMVCでは、PHP 5.4を正式サポートしてはおりませんが、PHP 5.4で互換がない変更は行わないで下さい。


PullRequestについて
--------------------------------------

コードの修正をいただいたら、EnviMVC宛てに、PullRequestを送って下さい。
修正のコミットは、一つにまとめていただけると幸いです。
下記にその方法を示します。


```
git checkout -b pullpeq/任意のブランチの名前
git merge --squash 今まで変更していたブランチ名
git commit

```

また、PullRequestでのコメントは、何を変更したのか。何のための変更なのか。を記載してください。
それ以外のルールはありません。



コーディング規約について
--------------------------------------

Pear標準コーディング規約に準拠する必要があります。
規約については[こちら](http://pear.php.net/manual/ja/standards.php)から参照することが出来ます。



バグ報告について
--------------------------------------

コードのコミットがなくとも、バグの報告、機能改善の要求だけでも、十分なプロジェクトへの貢献となりますので、発見し次第、[こちら](https://github.com/EnviMVC/EnviMVC3PHP/issues)から報告して下さい。

