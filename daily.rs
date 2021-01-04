impl Solution {
    pub fn min_patches(nums: Vec<i32>, n: i32) -> i32 {
        let (mut max,mut cnt)=(1,0); //exclusive
        nums.into_iter().filter(|&x|x<=n).for_each(|x|if max>=x as i64{max+=x as i64}else{while x as i64>max{max<<=1;cnt+=1}max+=x as i64});
        while n as i64>=max{max<<=1;cnt+=1}
        cnt
    }
}