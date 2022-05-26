<!--{template admin_header}-->
<style>
.block_border{
	border:solid 1px #ccc;
}
.content-wrapper, .right-side {
    min-height: 100%;
    background-color: #fff;
    z-index: 800;
}
</style>
<script src="//cdn.bootcss.com/echarts/3.4.0/echarts.min.js"></script>
           <div class="row">
             <div class="col-md-4 block_border">
              <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
    <div id="new_user_and_new_question" style="width: 100%;height:400px;"></div>
             
             
             </div>
                <div class="col-md-4 block_border" >
                      <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
   <div id="vertify_question_and_vertify_answer" style="width: 100%;height:400px;"></div>
             
             </div>
                   <div class="col-md-4 block_border" >
                      <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
   <div id="all_user_nosolve_solve" style="width: 100%;height:400px;"></div>
             
             </div>
                <div class="col-md-6 block_border">
                 <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
    <div id="week_new_user" style="width: 100%;height:400px;"></div>
             </div>
                <div class="col-md-6 block_border">
                 <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
    <div id="week_new_question" style="width: 100%;height:400px;"></div>
             </div>
           </div>
           
           <script>
           // 基于准备好的dom，初始化echarts实例 ---今日新增问题数和用户数
           var myChart = echarts.init(document.getElementById('new_user_and_new_question'));
         
       

           option = {
        		   title: {
                       text: '今日新增问题，用户，回答数'
                   },
               tooltip: {
                  
               },
               legend: {
                   orient: 'vertical',
                   x: 'right',
                   data:['新增问题数','新增用户数','新增回答数']
               },
               series: [
                   {
                      
                       type:'pie',
                       radius: ['40%', '50%', '50%'],
                       avoidLabelOverlap: false,
                       label: {
                           normal: {
                               show: true,
                               position: 'top'
                           },
                           emphasis: {
                               show: true,
                               textStyle: {
                                   fontSize: '20',
                                   fontWeight: 'bold'
                               }
                           }
                       },
                       itemStyle: {
                    	    normal: {
                    	        // 阴影的大小
                    	        shadowBlur: 200,
                    	        // 阴影水平方向上的偏移
                    	        shadowOffsetX: 0,
                    	        // 阴影垂直方向上的偏移
                    	        shadowOffsetY: 0,
                    	        // 阴影颜色
                    	        shadowColor: 'rgba(0, 0, 0, 0.5)',
                    	        color: function(params) {
                                    // build a color map as your need.
                                    var colorList = [
                                      '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
                                       '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
                                       '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                                    ];
                                    return colorList[params.dataIndex]
                                }
                    	    }
                    	},
                       labelLine: {
                           normal: {
                               show: false
                           }
                       },
                       data:[
                           {value:{$today_submit_question}, name:'新增问题数'},
                           {value:{$today_reg_user}, name:'新增用户数'},
                           {value:{$today_submit_answer}, name:'新增回答数'}
                         
                          
                       ]
                   }
               ]
           };
           // 使用刚指定的配置项和数据显示图表。
           myChart.setOption(option);
           
           
           var vertify_question_and_vertify_answer = echarts.init(document.getElementById('vertify_question_and_vertify_answer'));  
           
           //审核问题和回答
            vertifyoption = {
        		   title: {
                       text: '待审核问题[{$verifyquestions}]和回答[{$verifyanswers}]'
                   },
               tooltip: {
                  
               },
               legend: {
                   orient: 'vertical',
                   x: 'right',
                   data:['待审核问题数','待审核回答数']
               },
               series: [
                   {
                      
                       type:'pie',
                       radius: ['40%', '50%'],
                       avoidLabelOverlap: false,
                       label: {
                           normal: {
                               show: true,
                               position: 'left'
                           },
                           emphasis: {
                               show: true,
                               textStyle: {
                                   fontSize: '20',
                                   fontWeight: 'bold'
                               }
                           }
                       },
                       itemStyle: {
                    	    normal: {
                    	        // 阴影的大小
                    	        shadowBlur: 200,
                    	        // 阴影水平方向上的偏移
                    	        shadowOffsetX: 0,
                    	        // 阴影垂直方向上的偏移
                    	        shadowOffsetY: 0,
                    	        // 阴影颜色
                    	        shadowColor: 'rgba(0, 0, 0, 0.5)',
                    	        color: function(params) {
                                    // build a color map as your need.
                                    var colorList = [
                                      
                                       '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                                    ];
                                    return colorList[params.dataIndex]
                                }
                    	    }
                    	},
                       labelLine: {
                           normal: {
                               show: false
                           }
                       },
                       data:[
                           {value:{$verifyquestions}, name:'待审核问题数'},
                           {value:{$verifyanswers}, name:'待审核回答数'}
                         
                          
                       ]
                   }
               ]
           };
            // 使用刚指定的配置项和数据显示图表。
            vertify_question_and_vertify_answer.setOption(vertifyoption);
           
            
            
            //全部用户数，未解决，已解决问题数
             var all_user_nosolve_solve = echarts.init(document.getElementById('all_user_nosolve_solve'));
         
       

             all_user_nosolve_solve_option = {
        		   title: {
                       text: '全部用户数，未解决问题数，已解决问题数'
                   },
               tooltip: {
                  
               },
               legend: {
                   orient: 'vertical',
                   x: 'right',
                   data:['全部用户数','未解决问题数','已解决问题数','已关闭问题数']
               },
               series: [
                   {
                      
                       type:'pie',
                       radius: ['40%', '50%', '50%'],
                       avoidLabelOverlap: false,
                       label: {
                           normal: {
                               show: true,
                               position: 'top'
                           },
                           emphasis: {
                               show: true,
                               textStyle: {
                                   fontSize: '20',
                                   fontWeight: 'bold'
                               }
                           }
                       },
                       itemStyle: {
                    	    normal: {
                    	        // 阴影的大小
                    	        shadowBlur: 200,
                    	        // 阴影水平方向上的偏移
                    	        shadowOffsetX: 0,
                    	        // 阴影垂直方向上的偏移
                    	        shadowOffsetY: 0,
                    	        // 阴影颜色
                    	        shadowColor: 'rgba(0, 0, 0, 0.5)',
                    	        color: function(params) {
                                    // build a color map as your need.
                                    var colorList = [
                                    
                                      
                                       '#26C0C0','#F0805A','#D7504B','#C6E579','#F4E001'
                                    ];
                                    return colorList[params.dataIndex]
                                }
                    	    }
                    	},
                       labelLine: {
                           normal: {
                               show: false
                           }
                       },
                       data:[
                           {value:{$usercount}, name:'全部用户数'},
                           {value:{$nosolves}, name:'未解决问题数'},
                           {value:{$solves}, name:'已解决问题数'},
                           {value:{$closes}, name:'已关闭问题数'}
                         
                          
                       ]
                   }
               ]
           };
           // 使用刚指定的配置项和数据显示图表。
           all_user_nosolve_solve.setOption(all_user_nosolve_solve_option);
           
           
           //一周新增用户统计
           var weekuser = echarts.init(document.getElementById('week_new_user'));
         
           week_user_option = {
        		 
        		    title: {
        		        text: '近7日新增用户数'
        		    },
        		    tooltip : {
        		        trigger: 'axis'
        		    },
        		    legend: {
        		        data:['7日新增用户数']
        		    },
        		    toolbox: {
        		        feature: {
        		            saveAsImage: {}
        		        }
        		    },
        		   
        		    grid: {  
                        left: '3%',  
                        right: '4%',  
                        bottom: '3%',  
                        containLabel: true  
                    }, 
        		    xAxis : [
        		        {
        		            type : 'category',
        		            boundaryGap : false,
        		            data : ['{$week1}','{$week2}','{$week3}','{$week4}','{$week5}','{$week6}','{$nowdate}']
        		        }
        		    ],
        		    yAxis : [
        		        {
        		            type : 'value'
        		        }
        		    ],
        		    lineStyle:{
                        color:'#00FF00'
                },
        		    series : [
        		        {
        		            name:'新增用户数',
        		            type:'line',
        		            stack: '总量',
        		            areaStyle: {normal: {}},
        		        
        		            itemStyle : {  
                                normal : {  
                                    color:'#f5f5f5',  
                                   
                                    lineStyle:{  
                                        color:'#B03A5B'  
                                    }  
                                }  
                            },   
        		            data:[{$reg1}, {$reg2}, {$reg3}, {$reg4},{$reg5}, {$reg6}, {$reg7}]
        		        }
        		    ]
        		};
           // 使用刚指定的配置项和数据显示图表。
          weekuser.setOption(week_user_option);
           
          //一周新增用户统计
          var weekquestion = echarts.init(document.getElementById('week_new_question'));
        
          week_question_option = {
       		 
       		    title: {
       		        text: '一周新增问题数'
       		    },
       		    tooltip : {
       		        trigger: 'axis'
       		    },
       		    legend: {
       		        data:['新增问题数']
       		    },
       		    toolbox: {
       		        feature: {
       		            saveAsImage: {}
       		        }
       		    },
       		   
       		    grid: {  
                       left: '3%',  
                       right: '4%',  
                       bottom: '3%',  
                       containLabel: true  
                   }, 
       		    xAxis : [
       		        {
       		            type : 'category',
       		            boundaryGap : false,
    		            data : ['{$week1}','{$week2}','{$week3}','{$week4}','{$week5}','{$week6}','{$nowdate}']
       		        }
       		    ],
       		    yAxis : [
       		        {
       		            type : 'value'
       		        }
       		    ],
       		    lineStyle:{
                       color:'#00FF00'
               },
       		    series : [
       		        {
       		            name:'新增问题数',
       		            type:'line',
       		            stack: '总量',
       		            areaStyle: {normal: {}},
       		        
       		            itemStyle : {  
                               normal : {  
                                   color:'#f5f5f5',  
                                  
                                   lineStyle:{  
                                       color:'#c3b4df'  
                                   }  
                               }  
                           },   
       		            data:[{$question1},{$question2}, {$question3}, {$question4}, {$question5}, {$question6},{$question7}]
       		        }
       		    ]
       		};
          // 使用刚指定的配置项和数据显示图表。
         weekquestion.setOption(week_question_option);
           </script>
<!--{template admin_footer}-->