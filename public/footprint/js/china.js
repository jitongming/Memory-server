var width = 1000;
var height = 1000;
var dataset;//微博数据
var rootset;//地图数据
var address = Array();//获取dataset中地址信息
var female = Array();//记录微博博主的性别
var male = Array();
var rank_user_num = new Array();//排好序的各省份用户数
var name;
var svg = d3.select("#china_map").append("svg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(0,0)");

var projection = d3.geo.mercator()
    .center([107, 31])
    .scale(850)
    .translate([width / 2, height / 2]);

var path = d3.geo.path()
    .projection(projection);
//var color = d3.scale.category20();
var color = d3.scale.quantize().range(["#FFFFCC","#FFF2AE","#FEE590","#FED774","#FEBC56","#FDA144","#FC8539","#FC592D","#EF3423","#DB151D","#C10224","#9A0026","#800026"
]);
d3.csv("data/data_area_statistics.csv", function (error, data) {
    //设置颜色变换范围
    dataset = data;
    var max = d3.max(dataset, function (d) {
        return parseInt(d.user_num);
    });
    var min = d3.min(dataset, function (d) {
        return parseInt(d.user_num);
    });
    color.domain([min, max]);
    //读取csv数据文件，如果错误，输出错误
    if (error) {
        console.log(error);
    } else {
        d3.json("data/china.json", function (error, root) {
            if (error)
                return console.error(error);
            rootset = root;

            for(var i = 0; i < 34 ;i++){
                rank_user_num[i] = parseInt(dataset[i].user_num);
            }
            rank_user_num.sort(function(a,b){return a>b?1:-1});

            for (i = 0; i < dataset.length; i++) {
                var datacity = dataset[i].user_address;
                var dataValue = parseInt(dataset[i].user_num);
                for (var j = 0; j < rootset.features.length; j++) {
                    var rootcity = rootset.features[j].properties.name;
                    if (datacity == rootcity) {
                        female[j]=dataset[i].user_woman;
                        male[j]=dataset[i].user_man;
                        for(var k = 0;k < rank_user_num.length;k++){
                            if(rank_user_num[k] == dataValue){
                                break;
                            }
                        }
                        rootset.features[j].properties.value = k*140;
                        break;
                    }
                }
            }

            //布局地图
            svg.selectAll("path")
                .data(rootset.features)
                .enter()
                .append("path")
                .attr("stroke", "#CCFFFF")
                .attr("stroke-width", 2)
                .attr("fill", function (d){
                    return color(d.properties.value);
                })
                .attr("d", path)
                .on("mouseover",function(d,i){
                    d3.select(this)
                        .attr("fill","#00E1FB");
                    

                })
                .on("mouseout",function(d){
                    d3.select(this)
                        .attr("fill",color(d.properties.value));


                })
                .on("click",function(d,i){
                    document.getElementById("province").innerHTML=root.features[i].properties.name;
                    changedataradio = i;
                    var radio = document.getElementsByName("identity");

                    if(radio[0].checked){
                        readdata(i);
                    }else{
                        readdata_interest(i);
                    }
                    d3.select(this)
                        .attr("fill","#0033FF");

                    changeData(i);
                });
        });
    }
});
