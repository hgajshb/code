class Solution:
    def maxProfit(self, k: int, prices: List[int]) -> int:
        # 特判
        n = len(prices)
        if n <= 1 or k == 0:
            return 0

        # 找到 prices 中的全部递增子序列
        riseArea = []
        rise = [prices[0]]
        for i in range(1, n):
            if prices[i] >= rise[-1]:
                rise.append(prices[i])
            else:
                if len(rise) > 1:
                    riseArea.append([rise[0], rise[-1]])
                rise = [prices[i]]
        if len(rise) > 1:
            riseArea.append([rise[0], rise[-1]])

        # 计算最大收益
        totalMax = 0
        length = len(riseArea)
        for i in range(length):
            totalMax += riseArea[i][1] - riseArea[i][0]

        # 得到当前删减或合并区间的收益变化数组
        if length != 0:
            count = 0
            subArray = []
            while count < length - 1:
                subArray.append(riseArea[count][1] - riseArea[count][0])
                subArray.append(riseArea[count][1] - riseArea[count + 1][0])
                count += 1
            subArray.append(riseArea[count][1] - riseArea[count][0])

        # 若当前区间数仍大于要求数，则继续删减
        while length > k:

            # 找到删减的位置
            minValue = subArray[0]
            minIndex = 0
            for i in range(1, len(subArray)):
                if subArray[i] < minValue:
                    minValue = subArray[i]
                    minIndex = i

            # 若该位置为头尾区间处理
            if minIndex == 0:
                print(0)
                subArray.pop(0)
                subArray.pop(0)
                riseArea.pop(0)
                totalMax -= minValue
                length -= 1
                continue
            if minIndex == len(subArray) - 1:
                subArray.pop()
                subArray.pop()
                riseArea.pop()
                totalMax -= minValue
                length -= 1
                continue

            # 删去中间区间的处理和合并区间的处理
            if minIndex % 2 == 0:
                subArray.pop(minIndex - 1)
                subArray.pop(minIndex - 1)
                subArray.pop(minIndex - 1)
                subArray = (
                    subArray[: minIndex - 1]
                    + [riseArea[minIndex // 2 - 1][1] - riseArea[minIndex // 2 + 1][0]]
                    + subArray[minIndex - 1 :]
                )
                riseArea.pop(minIndex // 2)
                totalMax -= minValue
                length -= 1
            else:
                subArray.pop(minIndex - 1)
                subArray.pop(minIndex - 1)
                subArray.pop(minIndex - 1)
                subArray = (
                    subArray[: minIndex - 1]
                    + [riseArea[minIndex // 2 + 1][1] - riseArea[minIndex // 2][0]]
                    + subArray[minIndex - 1 :]
                )
                tmp = riseArea.pop(minIndex // 2)
                riseArea[minIndex // 2][0] = tmp[0]
                totalMax -= minValue
                length -= 1
        return totalMax