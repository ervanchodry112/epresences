

const Answer = (input) => {
   const words = input.split(" ");
   let count = 0;
   var regex = /^[A-Za-z0-9\?\.\,-]+$/i;

   words.forEach(v => {
      if (regex.test(v)) {
         count += 1;
      }
   })

   return count;
}

const main = () => {

   const input = [
      {
         input: "Kemarin Shopia per[gi ke mall.",
         expected: 4
      },
      {
         input: "Saat meng*ecat tembok, Agung dib_antu oleh Raihan.",
         expected: 5
      },
      {
         input: "Berapa u(mur minimal[ untuk !mengurus ktp?",
         expected: 3
      },
      {
         input: "Masing-masing anak mendap(atkan uang jajan ya=ng be&rbeda.",
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