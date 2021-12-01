/*
Ajax 三级省市联动
http://code.ciaoca.cn/
日期：2012-7-18

settings 参数说明
-----
url:省市数据josn文件路径
prov:默认省份
city:默认城市
dist:默认地区（县）
nodata:无数据状态
required:必选项
 */
(function($){
	$.fn.citySelect=function(settings){
		if(!this.length){return;}
		// 默认值
		settings=$.extend({
			url:'',
			country:'',
			prov:'',
			city:'',
			dist:'',
			nodata:'',
			required:true,
			country_name_key:'',
			p_name_key:'p',
			n_name_key:'n',
			s_name_key:'s',
			p_children_key:'c',
			n_children_key:'a',
			value_key:'value',
			data_val_key:'value',
			prehtml:1,
			required_title:METLANG.Choice ? METLANG.Choice : "请选择",
			getCityjson:function(json){
				return json.citylist;
			}
		},settings);
        var box_obj = this,
            country_obj = box_obj.find(".country"),
            prov_obj = box_obj.find(".prov"),
            city_obj = box_obj.find(".city"),
            dist_obj = box_obj.find(".dist"),
            select_prehtml = settings.required ? "" : (settings.prehtml?"<option value=''>" + settings.required_title + "</option>":''),
            jsondata,
			city_json,
			cityJson=function(index,fn){
				var this_fun=function(){
						city_json=settings.getCityjson(jsondata,index);
						typeof fn=='function' && fn(city_json);
					};
				if(jsondata){
					this_fun();
					return city_json;
				}else{
					var this_interval=setInterval(function(){
							if(jsondata){
								this_fun();
								clearInterval(this_interval);
							}
						},500)
				}
			},
			// 遍历赋值省份下拉列表
			provStart=function(){
				if(country_obj.length){
					var country_id=country_obj.get(0).selectedIndex;
					if(!settings.required && settings.prehtml){
						country_id--;
					};
					prov_obj.empty().attr("disabled",true);
					city_obj.empty().attr("disabled",true);
					dist_obj.empty().attr("disabled",true);
					if(country_id<0||typeof(jsondata[country_id].children)=="undefined"){
						if(settings.nodata=="none"){
							prov_obj.css("display","none");
							city_obj.css("display","none");
							dist_obj.css("display","none");
						}else if(settings.nodata=="hidden"){
							prov_obj.css("visibility","hidden");
							city_obj.css("visibility","hidden");
							dist_obj.css("visibility","hidden");
                        };
                        prov_obj.trigger('changes');
                        city_obj.trigger('changes');
					    dist_obj.trigger('changes');
						return;
					};
				}
				var temp_html=select_prehtml;
				if(typeof country_id != 'undefined') cityJson(country_id);
				$.each(city_json,function(i,prov){
					var tn = prov[settings.p_name_key].name?prov[settings.p_name_key].name:prov[settings.p_name_key];
					var tv = prov[settings.value_key]||prov[settings.value_key]==''?prov[settings.value_key]:(prov[settings.p_name_key][settings.value_key]||prov[settings.p_name_key][settings.value_key]==''?prov[settings.p_name_key][settings.value_key]:prov[settings.p_name_key]);
					temp_html+=prov[settings.p_name_key]==settings.required_title?"<option value=''>"+tn+"</option>":"<option value='"+tv+"' data-val='"+(prov[settings.data_val_key]||tn)+"'>"+tn+"</option>";
				});
				prov_obj.html(temp_html).attr("disabled",false).css({"display":"","visibility":""}).trigger('changes');
				cityStart();
			},
			// 赋值市级函数
			cityStart=function(){
				if(!city_obj.length) return;
				var prov_id=prov_obj.get(0).selectedIndex;
				if(!settings.required && settings.prehtml){
					prov_id--;
				};
				city_obj.empty().attr("disabled",true);
				dist_obj.empty().attr("disabled",true);

				if(prov_id<0||typeof(city_json[prov_id][settings.p_children_key])=="undefined"){
					if(settings.nodata=="none"){
						city_obj.css("display","none");
						dist_obj.css("display","none");
					}else if(settings.nodata=="hidden"){
						city_obj.css("visibility","hidden");
						dist_obj.css("visibility","hidden");
					};
					city_obj.trigger('changes');
					dist_obj.trigger('changes');
					return;
				};
				// 遍历赋值市级下拉列表
				var temp_html=select_prehtml;
				$.each(city_json[prov_id][settings.p_children_key],function(i,city){
					var tn = city[settings.n_name_key].name?city[settings.n_name_key].name:city[settings.n_name_key];
					var tv = city[settings.value_key]||city[settings.value_key]==''?city[settings.value_key]:(city[settings.n_name_key][settings.value_key]||city[settings.n_name_key][settings.value_key]==''?city[settings.n_name_key][settings.value_key]:city[settings.n_name_key]);
					temp_html+="<option value='"+tv+"' data-val='"+(city[settings.data_val_key]||tn)+"'>"+tn+"</option>";
				});
				city_obj.html(temp_html).attr("disabled",false).css({"display":"","visibility":""}).trigger('changes');
				distStart();
			},
			// 赋值地区（县）函数
			distStart=function(){
				if(!dist_obj.length) return;
				var prov_id=prov_obj.get(0).selectedIndex;
				var city_id=city_obj.get(0).selectedIndex;
				if(!settings.required && settings.prehtml){
					prov_id--;
					city_id--;
				};
				dist_obj.empty().attr("disabled",true);

				if(prov_id<0||city_id<0||typeof(city_json[prov_id][settings.p_children_key][city_id][settings.n_children_key])=="undefined"){
					if(settings.nodata=="none"){
						dist_obj.css("display","none");
					}else if(settings.nodata=="hidden"){
						dist_obj.css("visibility","hidden");
					};
					dist_obj.trigger('changes');
					return;
				};

				// 遍历赋值市级下拉列表
				// if(city_json[prov_id][settings.p_children_key][city_id][settings.n_children_key].length){
					var temp_html=select_prehtml;
					$.each(city_json[prov_id][settings.p_children_key][city_id][settings.n_children_key],function(i,dist){
						var tn = dist[settings.s_name_key].name?dist[settings.s_name_key].name:dist[settings.s_name_key];
						var tv = dist[settings.value_key]||dist[settings.value_key]==''?dist[settings.value_key]:(dist[settings.s_name_key][settings.value_key]||dist[settings.s_name_key][settings.value_key]==''?dist[settings.s_name_key][settings.value_key]:dist[settings.s_name_key]);
						temp_html+="<option value='"+tv+"' data-val='"+(dist[settings.data_val_key]||tn)+"'>"+tn+"</option>";
					});
					dist_obj.html(temp_html).attr("disabled",false).css({"display":"","visibility":""}).trigger('changes');
				// }
			},
			init=function(){
				if(country_obj.length && settings.country_name_key!=''){
					var temp_html=select_prehtml;;
					$.each(jsondata, function(index, val) {
						temp_html+='<option value="'+val[settings.value_key]+'" data-val="'+val[settings.country_name_key]+'">'+val[settings.country_name_key]+'</option>';
					});
					country_obj.html(temp_html);
					setTimeout(function(){
						if(settings.country){
							country_obj.val(settings.country).change();
						}else{
							country_obj.val(country_obj.find("option:eq(0)").attr("value")).change();
						}
					},1)
				}
				if(!country_obj.length){
					provStart();
					// 若有传入省份与市级的值，则选中。（setTimeout为兼容IE6而设置）
					setTimeout(function(){
						if(settings.prov!=''){
							prov_obj.val(settings.prov);
							cityStart();
							setTimeout(function(){
								if(settings.city!=''){
									city_obj.val(settings.city);
									distStart();
									setTimeout(function(){
										if(settings.dist!=''){
											dist_obj.val(settings.dist);
										};
									},1);
								};
							},1);
						};
					},1);
					setTimeout(function(){
						if(!settings.prov){
							prov_obj.val(prov_obj.find("option:eq(0)").attr("value"));
						}
					},2);
				}
				// 选择国家时发生事件
				country_obj.bind("change",function(){
					provStart();
				});
				// 选择省份时发生事件
				prov_obj.bind("change",function(){
					cityStart();
				});
				// 选择市级时发生事件
				city_obj.bind("change",function(){
					distStart();
				});
			},
			destroy=function(){
				country_obj.unbind('change',provStart);
				prov_obj.unbind('change',cityStart);
				city_obj.unbind('change',distStart);
			};
		// 设置省市json数据
		if(typeof(settings.url)=="string"){
			$.getJSON(settings.url,function(json){
				jsondata=json;
				city_json=settings.getCityjson(json);
				init();
			});
		}else{
			jsondata=settings.url;
			city_json=settings.url;
			init();
		};
		return {cityJson:cityJson,destroy:destroy};
	};
})(jQuery);