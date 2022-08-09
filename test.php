<?php
// 文字列周りで調査したスクリプト
echo 'script start!' . PHP_EOL;

$errorFileName = 'あいうえおカキクケコ-ABC_事業提提⽀援.pdf';
$kishuIzonCharacters = '①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑯⑰⑱⑲⑳ⅠⅡⅢⅣⅤⅥⅦⅧⅨⅩ㍉㌔㌢㍍㌘㌧㌃㌶㍑㍗㌍㌦㌣㌫㍊㌻㎜㎝㎞㎎㎏㏄㎡㍻〝〟№㏍℡㊤㊥㊦㊧㊨㈱㈲㈹㍾㍽㍼∮∑∟⊿纊褜鍈銈蓜俉炻昱棈鋹曻彅丨仡仼伀伃伹佖侒侊侚侔俍偀倢俿倞偆偰偂傔僴僘兊兤冝冾凬刕劜劦勀勛匀匇匤卲厓厲叝﨎咜咊咩哿喆坙坥垬埈埇﨏塚增墲夋奓奛奝奣妤妺孖寀甯寘寬尞岦岺峵崧嵓﨑嵂嵭嶸嶹巐弡弴彧德忞恝悅悊惞惕愠惲愑愷愰憘戓抦揵摠撝擎敎昀昕昻昉昮昞昤晥晗晙晴晳暙暠暲暿曺朎朗杦枻桒柀栁桄棏﨓楨﨔榘槢樰橫橆橳橾櫢櫤毖氿汜沆汯泚洄涇浯涖涬淏淸淲淼渹湜渧渼溿澈澵濵瀅瀇瀨炅炫焏焄煜煆煇凞燁燾犱犾猤猪獷玽珉珖珣珒琇珵琦琪琩琮瑢璉璟甁畯皂皜皞皛皦益睆劯砡硎硤硺礰礼神祥禔福禛竑竧靖竫箞精絈絜綷綠緖繒罇羡羽茁荢荿菇菶葈蒴蕓蕙蕫﨟薰蘒﨡蠇裵訒訷詹誧誾諟諸諶譓譿賰賴贒赶﨣軏﨤逸遧郞都鄕鄧釚釗釞釭釮釤釥鈆鈐鈊鈺鉀鈼鉎鉙鉑鈹鉧銧鉷鉸鋧鋗鋙鋐﨧鋕鋠鋓錥錡鋻﨨錞鋿錝錂鍰鍗鎤鏆鏞鏸鐱鑅鑈閒隆﨩隝隯霳霻靃靍靏靑靕顗顥飯飼餧館馞驎髙髜魵魲鮏鮱鮻鰀鵰鵫鶴鸙黑ⅰⅱⅲⅳⅴⅵⅶⅷⅸⅹ￤＇＂';

// 不正な文字は 機種依存文字?: true 実行結果: subject: ? strlen:1 mb_strlen:1  さらに: 1  比較結果: true 1バイト文字#半角英数字記号
$strArray = splitMultiByteString($errorFileName);
foreach ($strArray as $s) {
    //$s = $strArray[$i];
    echo "対象: " . $s . " ";
    $result = var_export(includesPlatFormDependentCharacters($s), true);
    echo "機種依存文字?: " . $result;
    echo " 実行結果: " . chkJIS1or2($s) . PHP_EOL;

}
// 機種依存文字はすべて、機種依存文字？: true 結果: subject: (対象1文字) strlen:2 mb_strlen:2  さらに: 2  比較結果: true 機種依存文字など
// $strArray2 = splitMultiByteString($kishuIzonCharacters);
// foreach ($strArray2 as $s) {
//     //$s = $strArray[$i];
//     echo "対象: " . $s . " ";
//     $result = var_export(includesPlatFormDependentCharacters($s), true);
//     echo "機種依存文字？: " . $result;
//     echo " 結果: " . chkJIS1or2($s) . PHP_EOL;
// }
// こちらの正しい"支"は、対象: 支 機種依存文字？: false 結果: subject: ?x strlen:2 mb_strlen:2  さらに: 2  比較結果: true 第一水準
$strArray2 = splitMultiByteString("支援");
foreach ($strArray2 as $s) {
    //$s = $strArray[$i];
    echo "対象: " . $s . " ";
    $result = var_export(includesPlatFormDependentCharacters($s), true);
    echo "機種依存文字？: " . $result;
    echo " 結果: " . chkJIS1or2($s) . PHP_EOL;
}

echo 'チェック用関数実行------' . PHP_EOL;
echo "不正なファイル名 " . var_export(includesIllegalCharacter($errorFileName), true) . PHP_EOL;
echo "機種依存文字 " . var_export(includesIllegalCharacter($kishuIzonCharacters), true) . PHP_EOL;
echo "正しいファイル名 " . var_export(includesIllegalCharacter("作業支援.pdf"), true) . PHP_EOL;


/**
 * 文字列中に問題となる不正な文字が含まれているかを判定します。
 * @param string $str 入力文字列
 * @returns boolean true:不正文字あり / false: 不正文字なし
 */
function includesIllegalCharacter($str) {
    // TODO: split...の関数の場所を移動する
    $strArray = splitMultiByteString($str);
    $includes = false;
    foreach ($strArray as $target) {
        // TODO: includes...の関数の場所を移動する
        if (!includesPlatFormDependentCharacters($target)) {
            continue;
        }
        // 通常の機種依存文字であれば支障はない。文字列の長さを得るstrlen:3 マルチバイト用のmb_strlen:1
        // sjis-win に変換した後は常にstr_len:2 mb_strlen:2 となる。
        $sjisWinStr = mb_convert_encoding($target, "sjis-win", 'utf-8');
        $len = strlen($sjisWinStr);
        $mbLen = mb_strlen($sjisWinStr);
        // sjis-win変換後に長さ1,マルチバイト用でも1と判定される漢字が不正で問題となる。おそらく特殊文字関連。
        if ($len === 1 && $mbLen === 1) {
            $includes = true;
            break;
        }
    }
    return $includes;
}


function splitMultiByteString($text) {
    return preg_split("//u", $text, -1, PREG_SPLIT_NO_EMPTY);
}

function includesPlatFormDependentCharacters($s) {
    return strlen($s) !== strlen(mb_convert_encoding(mb_convert_encoding($s,'SJIS','UTF-8'),'UTF-8','SJIS'));
}

    
// ネットの情報から借用した関数
// https://kazpgm.hatenadiary.org/entry/20100530/1275229871
// JISの半角および、第１、２水準文字であることのチェック。<br>
// @param    $target    検査する文字列
// @return    ""：OK、以外:NG文字たち
//
function chkJIS1or2($target){
    $rtn = "";
    for($idx = 0; $idx < mb_strlen($target, 'utf-8'); $idx++){
        $str0 = mb_substr($target, $idx, 1, 'utf-8');
        // 1文字をSJISにする。
        $str = mb_convert_encoding($str0, "sjis-win", 'utf-8');
//echo "−−−−−−−−−−−−\n";
//echo $str0 . "\n";
        //if (strlen($str) == 1) { // 1バイト文字
        $rtn .= "subject: " . $str . " strlen:" . strlen($str) . " mb_strlen:" . mb_strlen($str) . "  さらに: " . strlen(mb_convert_encoding(mb_convert_encoding($str,'SJIS','UTF-8'),'UTF-8','SJIS')) . " ";

        $sjis = mb_convert_encoding($str, 'SJIS', 'UTF-8');
        $sjisWin = mb_convert_encoding($str, 'SJIS-WIN', 'UTF-8');
        $compare = $sjis === $sjisWin;
        $rtn .= " 比較結果: " . var_export($compare, true) . " ";
        

        if ((strlen(bin2hex($str)) / 2) == 1) { // 1バイト文字
            $c = ord($str{0});
            $rtn .= "1バイト文字";
            
            // if (strlen($str) === mb_strlen($str)) {
            //     $rtn .= "#半角"; //全部こっちで判定できない
            // } else {
            //     $rtn .= "#違うかも";
            // }
            // if( preg_match( '/[^一-龠]/u', $str)) {
            //     $rtn .= "#漢字";//全部こっちでだめ
            // }else{
            //     $rtn .= "#ちがう";
            // }
            //if (preg_match("/^[一-龠]+$/u", $str)) {
            if (preg_match("/^[亜-龠]+$/u", $str)) {
                    $rtn .= "#漢字!"; // こない
            }
            if (preg_match('/^[!-~]+$/', $str)) {
                $rtn .= '#半角英数字記号'; //こっちにきちゃう。
            } else {
                $rtn .= '#違うよ';

            }
        } else {
            $c = ord($str{0}); // 先頭1バイト
//echo "c=" . $c . "\n";
            $c2 = ord($str{1}); // 2バイト目
//echo "c2=" . $c2 . "\n";
            $c3 = $c * 0x100 + $c2; // 2バイト分の数値にする。
//echo "c3=" . $c3 . "\n";
//echo "dechex_c3=" . dechex($c3) . "\n";
            if (($c3 >= 0x8140) && ($c3 <= 0x853D)) {// 2バイト文字
                $rtn .= "2バイト文字";
            } else if (($c3 >= 0x889F) && ($c3 <= 0x988F)) {// 第一水準
                $rtn .= "第一水準";
            } else if (($c3 >= 0x9890) && ($c3 <= 0x9FFF)) { // 第二水準
                $rtn .= "第二水準-1";
            } else if (($c3 >= 0xE040) && ($c3 <= 0xEAFF)) { // 第二水準
                $rtn .= "第二水準-2";
            } else {
                $rtn .= "機種依存文字など";
//echo "機種依存文字など" . "\n";
            }
        }
    }
    return $rtn;
}


