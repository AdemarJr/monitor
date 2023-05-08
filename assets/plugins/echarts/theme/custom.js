(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['exports', 'echarts'], factory);
    } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
        // CommonJS
        factory(exports, require('echarts'));
    } else {
        // Browser globals
        factory({}, root.echarts);
    }
}(this, function (exports, echarts) {
    var log = function (msg) {
        if (typeof console !== 'undefined') {
            console && console.error && console.error(msg);
        }
    };
    if (!echarts) {
        log('ECharts is not Loaded');
        return;
    }

    var colorPalette = [
        '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80',
        '#8d98b3','#e5cf0d','#97b552','#95706d','#dc69aa',
        '#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
        '#59678c','#c9ab00','#7eb00a','#6f5553','#c14089'
    ];


    var themeDefault = {
    color: ['#e52c3c','#f7b1ab','#fa506c','#f59288','#f8c4d8',
            '#e54f5c','#f06d5c','#e54f80','#f29c9f','#eeb5b7'],

    dataRange: {
        color:['#e52c3c','#f7b1ab']
    },

    
    k: {
        itemStyle: {
            normal: {
                color: '#e52c3c',
                color0: '#f59288',
                lineStyle: {
                    width: 1,
                    color: '#e52c3c',
                    color0: '#f59288'
                }
            },
            emphasis: {
                // color: 各异,
                // color0: 各异
            }
        }
    },
    
    // 饼图默认参数
    pie: {
        itemStyle: {
            normal: {
                // color: 各异,
                borderColor: '#fff',
                borderWidth: 1,
                label: {
                    show: true,
                    position: 'outer',
                  textStyle: {color: 'black'}
                    // textStyle: null      // 默认使用全局文本样式，详见TEXTSTYLE
                },
                labelLine: {
                    show: true,
                    length: 20,
                    lineStyle: {
                        // color: 各异,
                        width: 1,
                        type: 'solid'
                    }
                }
            }
        }
    },
    
    map: {
        mapType: 'china',   // 各省的mapType暂时都用中文
        mapLocation: {
            x : 'center',
            y : 'center'
            // width    // 自适应
            // height   // 自适应
        },
        showLegendSymbol : true,       // 显示图例颜色标识（系列标识的小圆点），存在legend时生效
        itemStyle: {
            normal: {
                // color: 各异,
                borderColor: '#fff',
                borderWidth: 1,
                areaStyle: {
                    color: '#ccc'//rgba(135,206,250,0.8)
                },
                label: {
                    show: false,
                    textStyle: {
                        color: 'rgba(139,69,19,1)'
                    }
                }
            },
            emphasis: {                 // 也是选中样式
                // color: 各异,
                borderColor: 'rgba(0,0,0,0)',
                borderWidth: 1,
                areaStyle: {
                    color: '#f3f39d'
                },
                label: {
                    show: false,
                    textStyle: {
                        color: 'rgba(139,69,19,1)'
                    }
                }
            }
        }
    },
    
    force : {
        // 分类里如果有样式会覆盖节点默认样式
        itemStyle: {
            normal: {
                // color: 各异,
                label: {
                    show: false
                    // textStyle: null      // 默认使用全局文本样式，详见TEXTSTYLE
                },
                nodeStyle : {
                    brushType : 'both',
                    strokeColor : '#e54f5c'
                },
                linkStyle : {
                    strokeColor : '#e54f5c'
                }
            },
            emphasis: {
                // color: 各异,
                label: {
                    show: false
                    // textStyle: null      // 默认使用全局文本样式，详见TEXTSTYLE
                },
                nodeStyle : {},
                linkStyle : {}
            }
        }
    },
    
    gauge : {
        axisLine: {            // 坐标轴线
            show: true,        // 默认显示，属性show控制显示与否
            lineStyle: {       // 属性lineStyle控制线条样式
                color: [[0.2, '#e52c3c'],[0.8, '#f7b1ab'],[1, '#fa506c']], 
                width: 8
            }
        },
        axisTick: {            // 坐标轴小标记
            splitNumber: 10,   // 每份split细分多少段
            length :12,        // 属性length控制线长
            lineStyle: {       // 属性lineStyle控制线条样式
                color: 'auto'
            }
        },
        axisLabel: {           // 坐标轴文本标签，详见axis.axisLabel
            textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                color: 'auto'
            }
        },
        splitLine: {           // 分隔线
            length : 18,         // 属性length控制线长
            lineStyle: {       // 属性lineStyle（详见lineStyle）控制线条样式
                color: 'auto'
            }
        },
        pointer : {
            length : '90%',
            color : 'auto'
        },
        title : {
            textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                color: '#333'
            }
        },
        detail : {
            textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                color: 'auto'
            }
        }
    }
};

    var themeHelianthus = {
        backgroundColor: '#F2F2E6',
        // 默认色板
        color: [
            '#44B7D3','#E42B6D','#F4E24E','#FE9616','#8AED35',
            '#ff69b4','#ba55d3','#cd5c5c','#ffa500','#40e0d0',
            '#E95569','#ff6347','#7b68ee','#00fa9a','#ffd700',
            '#6699FF','#ff6666','#3cb371','#b8860b','#30e0e0'
        ],

        // 图表标题
        title: {
            backgroundColor: '#F2F2E6',
            itemGap: 10,               // 主副标题纵向间隔，单位px，默认为10，
            textStyle: {
                color: '#8A826D'          // 主标题文字颜色
            },
            subtextStyle: {
                color: '#E877A3'          // 副标题文字颜色
            }
        },

        // 值域
        dataRange: {
            x:'right',
            y:'center',
            itemWidth: 5,
            itemHeight:25,
            color:['#E42B6D','#F9AD96'],
            text:['高','低'],         // 文本，默认为数值文本
            textStyle: {
                color: '#8A826D'          // 值域文字颜色
            }
        },

        toolbox: {
            color : ['#E95569','#E95569','#E95569','#E95569'],
            effectiveColor : '#ff4500',
            itemGap: 8
        },

        // 提示框
        tooltip: {
            backgroundColor: 'rgba(138,130,109,0.7)',     // 提示背景颜色，默认为透明度为0.7的黑色
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'line',         // 默认为直线，可选为：'line' | 'shadow'
                lineStyle : {          // 直线指示器样式设置
                    color: '#6B6455',
                    type: 'dashed'
                },
                crossStyle: {          //十字准星指示器
                    color: '#A6A299'
                },
                shadowStyle : {                     // 阴影指示器样式设置
                    color: 'rgba(200,200,200,0.3)'
                }
            }
        },

        // 区域缩放控制器
        dataZoom: {
            dataBackgroundColor: 'rgba(130,197,209,0.6)',            // 数据背景颜色
            fillerColor: 'rgba(233,84,105,0.1)',   // 填充颜色
            handleColor: 'rgba(107,99,84,0.8)'     // 手柄颜色
        },

        // 网格
        grid: {
            borderWidth:0
        },

        // 类目轴
        categoryAxis: {
            axisLine: {            // 坐标轴线
                lineStyle: {       // 属性lineStyle控制线条样式
                    color: '#6B6455'
                }
            },
            splitLine: {           // 分隔线
                show: false
            }
        },

        // 数值型坐标轴默认参数
        valueAxis: {
            axisLine: {            // 坐标轴线
                show: false
            },
            splitArea : {
                show: false
            },
            splitLine: {           // 分隔线
                lineStyle: {       // 属性lineStyle（详见lineStyle）控制线条样式
                    color: ['#FFF'],
                    type: 'dashed'
                }
            }
        },

        polar : {
            axisLine: {            // 坐标轴线
                lineStyle: {       // 属性lineStyle控制线条样式
                    color: '#ddd'
                }
            },
            splitArea : {
                show : true,
                areaStyle : {
                    color: ['rgba(250,250,250,0.2)','rgba(200,200,200,0.2)']
                }
            },
            splitLine : {
                lineStyle : {
                    color : '#ddd'
                }
            }
        },

        timeline : {
            lineStyle : {
                color : '#6B6455'
            },
            controlStyle : {
                normal : { color : '#6B6455'},
                emphasis : { color : '#6B6455'}
            },
            symbol : 'emptyCircle',
            symbolSize : 3
        },

        // 柱形图默认参数
        bar: {
            itemStyle: {
                normal: {
                    barBorderRadius: 0
                },
                emphasis: {
                    barBorderRadius: 0
                }
            }
        },

        // 折线图默认参数
        line: {
            smooth : true,
            symbol: 'emptyCircle',  // 拐点图形类型
            symbolSize: 3           // 拐点图形大小
        },


        // K线图默认参数
        k: {
            itemStyle: {
                normal: {
                    color: '#E42B6D',       // 阳线填充颜色
                    color0: '#44B7D3',      // 阴线填充颜色
                    lineStyle: {
                        width: 1,
                        color: '#E42B6D',   // 阳线边框颜色
                        color0: '#44B7D3'   // 阴线边框颜色
                    }
                }
            }
        },

        // 散点图默认参数
        scatter: {
            itemStyle: {
                normal: {
                    borderWidth:1,
                    borderColor:'rgba(200,200,200,0.5)'
                },
                emphasis: {
                    borderWidth:0
                }
            },
            symbol: 'circle',    // 图形类型
            symbolSize: 4        // 图形大小，半宽（半径）参数，当图形为方向或菱形则总宽度为symbolSize * 2
        },

        // 雷达图默认参数
        radar : {
            symbol: 'emptyCircle',    // 图形类型
            symbolSize:3
            //symbol: null,         // 拐点图形类型
            //symbolRotate : null,  // 图形旋转控制
        },

        map: {
            itemStyle: {
                normal: {
                    areaStyle: {
                        color: '#ddd'
                    },
                    label: {
                        textStyle: {
                            color: '#E42B6D'
                        }
                    }
                },
                emphasis: {                 // 也是选中样式
                    areaStyle: {
                        color: '#fe994e'
                    },
                    label: {
                        textStyle: {
                            color: 'rgb(100,0,0)'
                        }
                    }
                }
            }
        },

        force : {
            itemStyle: {
                normal: {
                    nodeStyle : {
                        borderColor : 'rgba(0,0,0,0)'
                    },
                    linkStyle : {
                        color : '#6B6455'
                    }
                }
            }
        },

        chord : {
            itemStyle : {
                normal : {
                    chordStyle : {
                        lineStyle : {
                            width : 0,
                            color : 'rgba(128, 128, 128, 0.5)'
                        }
                    }
                },
                emphasis : {
                    chordStyle : {
                        lineStyle : {
                            width : 1,
                            color : 'rgba(128, 128, 128, 0.5)'
                        }
                    }
                }
            }
        },

        gauge : {                  // 仪表盘
            center:['50%','80%'],
            radius:'100%',
            startAngle: 180,
            endAngle : 0,
            axisLine: {            // 坐标轴线
                show: true,        // 默认显示，属性show控制显示与否
                lineStyle: {       // 属性lineStyle控制线条样式
                    color: [[0.2, '#44B7D3'],[0.8, '#6B6455'],[1, '#E42B6D']],
                    width: '40%'
                }
            },
            axisTick: {            // 坐标轴小标记
                splitNumber: 2,   // 每份split细分多少段
                length: 5,        // 属性length控制线长
                lineStyle: {       // 属性lineStyle控制线条样式
                    color: '#fff'
                }
            },
            axisLabel: {           // 坐标轴文本标签，详见axis.axisLabel
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    color: '#fff',
                    fontWeight:'bolder'
                }
            },
            splitLine: {           // 分隔线
                length: '5%',         // 属性length控制线长
                lineStyle: {       // 属性lineStyle（详见lineStyle）控制线条样式
                    color: '#fff'
                }
            },
            pointer : {
                width : '40%',
                length: '80%',
                color: '#fff'
            },
            title : {
                offsetCenter: [0, -20],       // x, y，单位px
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    color: 'auto',
                    fontSize: 20
                }
            },
            detail : {
                offsetCenter: [0, 0],       // x, y，单位px
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    color: 'auto',
                    fontSize: 40
                }
            }
        },

        textStyle: {
            fontFamily: '微软雅黑, Arial, Verdana, sans-serif'
        }
    };

    echarts.registerTheme('custom', themeDefault);
}));