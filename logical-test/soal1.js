

const Answer = (input) => {
   let count = 0;

   let element = [];

   input.forEach(v => {
      if (element.includes(v)) {
         return;
      }

      const filtered = input.filter(val => v == val)

      if (filtered.length >= 2) {
         element.push(v)

         count += Math.floor(filtered.length / 2)

      }
   })

   return count;
}

const main = () => {

   const input = [
      {
         input: [5, 7, 7, 9, 10, 4, 5, 10, 6, 5],
         expected: 3
      },
      {
         input: [10, 20, 20, 10, 10, 30, 50, 10, 20],
         expected: 3
      },
      {
         input: [6, 5, 2, 3, 5, 2, 2, 1, 1, 5, 1, 3, 3, 3, 5],
         expected: 6
      },
      {
         input: [1, 1, 3, 1, 2, 1, 3, 3, 3, 3],
         expected: 4
      },
   ];

   input.forEach(obj => {
      const res = Answer(obj.input);
      console.log(`Input : ${obj.input}`)
      console.log(`Expected Output : ${obj.expected}`)
      console.log(`Output : ${res}`)
      console.log(res === obj.expected ? "Success!!\n" : "Failed!!\n")
   })

}

main();