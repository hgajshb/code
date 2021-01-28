
// * Definition for singly-linked list.
function ListNode(val) {
    this.val = val;
    this.next = null;
}

/**
 * @param {ListNode} head
 * @return {ListNode}
 */
var middleNode = function (head) {
    let fast, slow;
    fast = slow = head;
    while (fast && fast.next) {
        fast = fast.next.next;
        slow = slow.next;
    }
    slow = fast ? slow : slow.next;
    return slow;
};

/**
 * @param {ListNode} node
 * @return {void} Do not return anything, modify node in-place instead.
 */
var deleteNode = function (node) {
    node.val = node.next.val;
    node.next = node.next.next;
};

let head = new ListNode(4);
head.next = new ListNode(5);
head.next.next = new ListNode(9);
head.next.next.next = new ListNode(11);
deleteNode(head.next);
while (head) {
    console.log(head.val);
    head = head.next;
}