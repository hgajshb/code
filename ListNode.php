<?php


// Definition for a singly-linked list.
class ListNode
{
    public $val = 0;
    public $next = null;
    function __construct($val)
    {
        $this->val = $val;
    }
}

class Solution
{

    /**
     * @param ListNode $head
     * @param Integer $x
     * @return ListNode
     */
    function partition($head, $x)
    {
        $a = $less = new ListNode(0);
        $b = $eqmore = new ListNode(0);
        while ($head) {
            if ($head->val < $x) {
                $less->next = $head;
                $less = $less->next;
            } else {
                $eqmore->next = $head;
                $eqmore = $eqmore->next;
            }
            $head = $head->next;
        }
        $eqmore->next = null;
        $less->next = $b->next;
        return $a->next;
    }
}
//head = 1->4->3->2->5->2, x = 3
$head = new ListNode(1);
$head->next = new ListNode(4);
$head->next->next = new ListNode(3);
$head->next->next->next = new ListNode(2);
$head->next->next->next->next = new ListNode(5);
$head->next->next->next->next->next = new ListNode(2);

$ns = new Solution;
$nhead = $ns->partition($head, 3);
while ($nhead) {
    echo $nhead->val;
    $nhead = $nhead->next;
}
