// wordpress默认编辑器添加自定义按钮
(function() {
   tinymce.create('tinymce.plugins.recentposts', {
      init : function(ed, url) {
		
		 // 表格按钮
         ed.addButton('recentposts', {
            title : '插入表格',
            image : url + '/table.png',
            onclick : function() {
               var row = prompt("表格的行数", "2");
               var column = prompt("表格的列数", "2");
				if (row == null || row == '') {
					row = '1';
				}
				if (column == null || column == '') {
					column = '1';
				}
				
				var rowCount = parseInt(row);
				var columnCount = parseInt(column);
				
				// 生成table代码
				var html = '<table class="table table-bordered">';
				for (var r = 0; r < columnCount; r++) {
					html += '<tr>';
					for (var i = 0; i < columnCount; i++) {
						html += '<td></td>';
					}
					html += '</tr>';
				}
				
				html += '</table>';

               	ed.execCommand('mceInsertContent', false, html);
            }
         });
		 
		 // demo按钮
		 ed.addButton('demo', {
            title : '插入demo按钮',
            image : url + '/table.png',
            onclick : function() {
               var row = prompt("表格的行数", "2");
               var column = prompt("表格的列数", "2");
				if (row == null || row == '') {
					row = '1';
				}
				if (column == null || column == '') {
					column = '1';
				}
				
				var rowCount = parseInt(row);
				var columnCount = parseInt(column);
				
				// 生成table代码
				var html = '<table class="table table-bordered">';
				for (var r = 0; r < columnCount; r++) {
					html += '<tr>';
					for (var i = 0; i < columnCount; i++) {
						html += '<td></td>';
					}
					html += '</tr>';
				}
				
				html += '</table>';

               	ed.execCommand('mceInsertContent', false, html);
            }
         });
		 
		 
      },
      createControl : function(n, cm) {
         return null;
      },
   });
   tinymce.PluginManager.add('recentposts', tinymce.plugins.recentposts);
   
})();
