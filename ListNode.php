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

    /**
     * @param ListNode $l1
     * @param ListNode $l2
     * @return ListNode
     */
    function mergeTwoLists($l1, $l2)
    {
        $ret = $dummy = new ListNode(0);
        while ($l1 && $l2) {
            if ($l1->val > $l2->val) {
                $dummy->next = $l2;
                $l2 = $l2->next;
            } else {
                $dummy->next = $l1;
                $l1 = $l1->next;
            }
            $dummy = $dummy->next;
        }
        if ($l1) $dummy->next = $l1;
        if ($l2) $dummy->next = $l2;
        return $ret->next;
    }

    /**
     * @param ListNode $head
     * @return ListNode
     */
    function deleteDuplicates($head)
    {
        if (!$head) return;
        $ret = $dummy = new ListNode(PHP_INT_MAX);
        $a = $head;
        $freq = [];
        while ($head) {
            $freq[$head->val] = isset($freq[$head->val]) ? $freq[$head->val] + 1 : 1;
            $head = $head->next;
        }
        while ($a) {
            if ($freq[$a->val] == 1) {
                $dummy->next = new ListNode($a->val);
                $dummy = $dummy->next;
            }
            $a = $a->next;
        }
        return $ret->next;
    }
}
//head = 1->4->3->2->5->2, x = 3
//[1,2,3,3,4,4,5]
$head = new ListNode(1);
$head->next = new ListNode(1);
$head->next->next = new ListNode(1);
$head->next->next->next = new ListNode(2);
$head->next->next->next->next = new ListNode(3);
//$head->next->next->next->next->next = new ListNode(4);
//$head->next->next->next->next->next->next = new ListNode(5);

$ns = new Solution;
$nhead = $ns->deleteDuplicates($head);
while ($nhead) {
    echo $nhead->val;
    $nhead = $nhead->next;
}
