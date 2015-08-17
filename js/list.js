BUI.use(['bui/data', 'bui/grid', 'bui/toolbar', 'bui/calendar'],function(Data, Grid, Toolbar, Calendar){
    var columns = [
        {title:"编号",elCls:"center",dataIndex:"id",width:"10%"},
        {title:"标题",elCls:"center",dataIndex:"title",width:"15%"},
        {title:"内容",elCls:"center",dataIndex:"content",width:"45%"},
        {title:"发布时间",elCls:"center",dataIndex:"time",width:"20%"},
        {title:"操作",elCls:"center",dataIndex:"op",width:"10%",renderer:function(){ return "<a class='edit'>编辑</a>"; }}
    ];

    var editing = new Grid.Plugins.DialogEditing({
        contentId : 'dialog',
        triggerCls : 'edit',
        editor : {
            title : '文章编辑',
            width : 600,
            listeners : {
                show : function(){
                    //TO DO
                }
            }
        },
        autoSave: true
    }),
    store = new Data.Store({
        url: './?g=news/list&get=1',
        autoLoad: true,
        pageSize: 10,
        proxy: {
            method: "POST",
            save: "./?g=news/list"
        }
    }),
    grid = new Grid.Grid({
        render: "#grid",
        columns : columns,
        innerBorder : false,
        width: 1000,
        store : store,
        tbar:{
            elCls: "tbar",
            items : [{
                btnCls : 'button button-success',
                text : '<i class="icon-white icon-plus"></i>添加',
                listeners : {
                    'click' : addFunc
                }
            },
            {
                btnCls : 'button button-danger',
                text : '<i class="icon-white icon-remove"></i>删除',
                listeners : {
                    'click' : delFunc
                }
            }]
        },
        plugins : [editing,Grid.Plugins.CheckSelection]
    }),
    paging = new Toolbar.NumberPagingBar({
        render: '#paging',
        elCls: 'pagination pull-left',
        store: store
    });

    grid.render();
    paging.render();

    store.on("saved",function(ev){
        var type = ev.type;
        saveData = ev.saveData;
        data = ev.data;

        if(type == 'add'){
            saveData.id = data.id;
            saveData.time = data.time;
            store.update();
            grid.updateItem(saveData);
            BUI.Message.Alert('<h2>添加成功</h2><br/><p class="auxiliary-text">成功添加 '+data.num+' 条记录！</p>','success');
        }else if(type == 'update'){
            BUI.Message.Alert('<h2>更新成功</h2><br/><p class="auxiliary-text">成功更新 '+data.num+' 条记录！</p>','success');
        }else{
            BUI.Message.Alert('<h2>删除成功</h2><br/><p class="auxiliary-text">　共选中 '+data.sum+' 条记录</p><p class="auxiliary-text">成功删除 '+data.num+' 条记录！</p>','success');
        }
    });

    store.on("exception",function(ev){
        BUI.Message.Alert("操作失败","error");
    });

    function addFunc(){
        var newData = {};
        editing.add(newData,'address');
    }

    function delFunc(){
        var selections = grid.getSelection(),
            ids = BUI.Array.map(selections,function (item) {
                return item.id;
            });
        store.remove(selections);
        store.save('remove',{ids : ids.join(',')});
    }

});