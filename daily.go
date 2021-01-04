package main

import (
	"fmt"
)

func minPatches(nums []int, n int) int {
	total := 0
	count := 0
	index := 0
	for total < n {
		if index < len(nums) && nums[index] <= total+1 {
			total += nums[index]
			index++
		} else {
			total = total + (total + 1)
			count++
		}
	}
	return count
}
func main() {
	nums := []int{1, 3}
	n := 6
	nums = []int{1, 5, 10}
	n = 20
	fmt.Println(minPatches(nums, n))
}
