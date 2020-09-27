<?php

namespace MyApp;

class Calendar {
    //プロパティ定義
    public $prev;
    public $next;
    public $yearMonth;
    private $_thisMonth;

    //コンストラクタ
    public function __construct() {
        //tでGETした値から日付オブジェクトを取得してCalenderクラスの$thisMonthに代入
        try {
            //tがセットされていない、または$_GET['t']と'数値4桁-数値2桁'の型がマッチ（完全一致）しない場合
            if (!isset($_GET['t']) || !preg_match('/\A\d{4}-\d{2}\z/', $_GET['t'])) {
                throw new \Exception();
            }
            //ちゃんとセットされていたら、GETの日付を代入
            $this->_thisMonth = new \DateTime($_GET['t']);
        } catch (\Exception $e) {
            //例外は今月にする
            $this->_thisMonth = new \DateTime('first day of this month');
        }
        
        //$this:Calenderクラスの$prevに、Calenderクラスの$_createPrevLink()の結果を代入
        $this->prev = $this->_createPrevLink();
        $this->next = $this->_createNextLink();
        $this->yearMonth = $this->_thisMonth->format('F Y');
    }

    private function _createPrevLink() {
        //一旦複製してからmodifyで$prev,$nextを作る
        $dt = clone $this->_thisMonth;
        return $dt->modify('-1 month')->format('Y-m');
    }
    private function _createNextLink() {
        $dt = clone $this->_thisMonth;
        return $dt->modify('+1 month')->format('Y-m');
    }

    public function show() {
         $tail = $this->_getTail();
         $body = $this->_getBody();
         $headOfMonth = $this->_getHead();

        $html = '<tr>' . $tail . $body . $headOfMonth . '</tr>';
        echo $html;
    }

    private function _getTail() {
        $tail = '';
        $lastDayOfPrevMonth = new \DateTime('last day of ' . $this->yearMonth . ' -1 month');
        while ($lastDayOfPrevMonth->format('w') < 6) {
            $tail = sprintf('<td class="gray">%d</td>', $lastDayOfPrevMonth->format('d')) . $tail;
            $lastDayOfPrevMonth->sub(new \DateInterval('P1D'));
        }
        return $tail;
    }
    private function _getBody() {
        $body = '';
        //DatePeriodクラスを使って期間と表示間隔を設定
        $period = new \DatePeriod(
            //開始日
            new \DateTime('first day of ' . $this->yearMonth),
            //1日ごとの間隔で
            new \DateInterval('P1D'),
            //終了日(この日を含まない)
            new \DateTime('first day of ' . $this->yearMonth . ' +1 month')
        );

        $today = new \DateTime('today');
        //今月＆今日の表示
        foreach ($period as $day) {
            //'w'でフォーマットすると日曜が0～土曜が6となるので、0の前に改行(tr閉じタグ＆開始タグ)を入れる
            if ($day->format('w') === '0') {
                $body .= '</tr><tr>';
            }
            //$dayが今日の日付と一致したらtodayクラスを付与、そうでなければ空(1行のif文)
            $todayClass = ($day->format('Y-m-d') === $today->format('Y-m-d')) ? 'today' : '';
            $body .= sprintf(
                //%sには文字列、%dには数値を順番に入れられるので、最初の%dには'w'の数値が入っている。
                '<td class="youbi_%d %s">%d</td>',
                //$dayの中身を'w','d'にフォーマット
                $day->format('w'),
                $todayClass,
                $day->format('d')
            );
        }
        return $body;
    }
    private function _getHead() {
        $headOfMonth = '';
        //翌月1日の日付取得
        $firstDayOfNextMonth = new \DateTime('first day of ' . $this->yearMonth . ' +1 month');
        //翌月1日が0以上、つまり日曜以降である間 = 次の日曜(土曜末)まではgrayクラスをつけて表示
        while ($firstDayOfNextMonth->format('w') > 0) {
            $headOfMonth .= sprintf(
                '<td class="gray">%d</td>',
                $firstDayOfNextMonth->format('d')
            );
            $firstDayOfNextMonth->add(new \DateInterval('P1D'));
        }
        return $headOfMonth;
    }
}