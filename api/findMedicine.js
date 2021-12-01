function findMedicine(symptoms) {
  //const symptom = document.querySelector("#symptom").innerText;
  const symptom = symptoms;
  const handlingCORS = "https://cors.bridged.cc/";

  const MEDICINE_API_KEY =
    "Ta6sT%2BivsJ1PVZrsEg4KJQ1A35VgZcgnO1lMFHw0YueFyfqn6Gi0Csllevy1veAryofhGi2SPe1Tp0H4IVvccg%3D%3D";

  const medicineNumber = 10;

  $.ajax({
    url: `${handlingCORS}http://apis.data.go.kr/1471000/DrbEasyDrugInfoService/getDrbEasyDrugList?serviceKey=${MEDICINE_API_KEY}&numOfRows=${medicineNumber}&type=json&efcyQesitm=${symptom}`,
    type: "GET",
    //dataType: "json",
    success: function (data) {
      console.log("Ajax 요청 성공");
      console.log(data.body.items[1].itemName);

      for (let i = 0; i < medicineNumber; i++) {
        const itemName = data.body.items[i].itemName;
        console.log(itemName);
      }
    },
    error: function (request, status, error) {
      alert("Ajax 요청 실패");
    },
  });
}

function submitTest(event) {
  event.preventDefault();
  const symptomForm = document.getElementById("symptomInput");
  const symptom = symptomForm.value;
  console.log("증상: " + symptom);
  symptomForm.value = "";
  findMedicine(symptom);
}

document.querySelector("#submit-form").addEventListener("submit", submitTest);
document.querySelector("#submit-test").addEventListener("click", submitTest);

document
  .querySelector("#find-medicine")
  .addEventListener("click", findMedicine);
