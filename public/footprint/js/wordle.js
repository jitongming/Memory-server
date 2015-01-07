var dataset_wordle;
var sum =Array(Array());
var count =Array(Array());
var sum_interest = Array(Array());
var count_interest=Array(Array());
var changedataradio;

var svgwordle = d3.select("#wordle").append("svg")
    .attr("width", 600)
    .attr("height", 400);
    //.attr("style","border:1px solid red");


//读取省份的用户标签信息
d3.json("data/province_user_tag.json", function (error, data){
    if(error){
        return console.error(error);
    }

    var i;
    for( i = 0;i <data.features.length;i++){
        var subsum = Array();
        var subcount = Array();
        var labels = data.features[i].labels;
         for(var j=0;j<labels.length;j++){
            subcount[j] = labels[j].weight;
            subsum[j] =  labels[j].label;
       }
        sum[i] = subsum;
        count[i] = subcount;
    }
});
//读取省份的用户兴趣信息
d3.json("data/province_user_interest.json", function (error, data){
    if(error){
        return console.error(error);
    }
    dataset_wordle = data;

    var i;
    for( i = 0;i <data.features.length;i++){
        var subsum = Array();
        var subcount = Array();
        var labels = data.features[i].labels;
        for(var j=0;j<labels.length;j++){
            subsum[j] =  labels[j].label;
            subcount[j] = labels[j].weight;
        }
        sum_interest[i] = subsum;
        count_interest[i] = subcount;
    }
});
function readdata(m){
    var fill = d3.scale.category20();
    var maxweight = d3.max(count[m]);
        d3.layout.cloud().size([600,400])
            .words(sum[m].map(function(d,i) {
                return {"text": d, "size": 100*count[m][i]/maxweight};
            }))
            .rotate(function() { return ~~(Math.random() * 2) * 90; })
            .font("Impact")
            .fontSize(function(d,i) {
                return 100*count[m][i]/maxweight;
             })
            .on("end", draw)
            .start();

        function draw(words) {
            svgwordle.selectAll("g").remove();
                svgwordle
                .append("g")
                .attr("transform", "translate(300,200)")
                .selectAll("text")
                .data(words)
                .enter()
                .append("text")
                .style("border","1px solid blue")
                .style("font-size", function(d) { return d.size + "px"; })
                .style("font-family", "Impact")
                .style("fill", function(d, i) { return fill(i); })
                .attr("text-anchor", "middle")
                .attr("transform", function(d) {
                    return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
                })
                .text(function(d) { return d.text; });
        }
}

function readdata_interest(m){
    var fill = d3.scale.category20();
    var maxweight = d3.max(count_interest[m]);
    d3.layout.cloud().size([600,400])
        .words(sum_interest[m].map(function(d,i) {
            //alert(count[m][i]/maxweight);
            return {"text": d, "size": 200*count_interest[m][i]/maxweight};
        }))
        .rotate(function() { return ~~(Math.random() * 2) * 90; })
        .font("Impact")
        .fontSize(function(d,i) {
            return 200*count_interest[m][i]/maxweight;
        })
        .on("end", draw)
        .start();

    function draw(words) {
        svgwordle.selectAll("g").remove();
        svgwordle
            .append("g")
            .attr("transform", "translate(300,200)")
            .selectAll("text")
            .data(words)
            .enter()
            .append("text")
            .style("border","1px solid blue")
            .style("font-size", function(d) { return d.size + "px"; })
            .style("font-family", "Impact")
            .style("fill", function(d, i) { return fill(i); })
            .attr("text-anchor", "middle")
            .attr("transform", function(d) {
                return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
            })
            .text(function(d) { return d.text; });
    }
}