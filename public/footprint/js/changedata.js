var svg = d3.select("#sex_donut").append("svg").attr("width", 300).attr("height", 300);
//
svg.append("g").attr("id", "quotesDonut");

var salesData1 = [
    {sex: "male", color: "#3366CC"},
    {sex: "female", color: "#DC3912"}
];
Donut3D.draw("quotesDonut", initialData1(), 150, 150, 130, 100, 30, 0);

function initialData1() {
    return salesData1.map(function (d) {
        return {sex: d.sex, value: 1, color: d.color};
    });
}



function setNewData(i) {
    var salesData = [
        {sex: "male", color: "#3366CC",value:male[i]},
        {sex: "female", color: "#DC3912",value:female[i]}
    ]
    return salesData.map(function (d) {
        return {sex: d.sex, value: d.value, color: d.color};
    });
}
function changeData(i) {
    Donut3D.transition("quotesDonut", setNewData(i), 130, 100, 30, 0);
}