/**
 *
 * -------------------------------------------
 * Add shortcode shorthand for classic editor fans. It's soooooooo good.
 * -------------------------------------------
 *
 **/

( function() {
	'use strict';
	const shortcodeTemplates = [
		{
			title: 'Warning / Info / Notice',
			code: '',
			submenu: [
				{
					title: 'Warning',
					code: '[warning]Your text[/warning]',
				},
				{
					title: 'Info',
					code: '[info]Your text[/info]',
				},
				{
					title: 'Notice',
					code: '[notice]Your text[/notice]',
				},
				{
					title: 'Error',
					code: '[error]Your text[/error]',
				},
			],
		},
		{
			title: 'Labels',
			code: '[label]Your text[/label]',
			submenu: [
				{
					title: 'Style 1',
					code: '[label style="1"]Your text[/label]',
				},
				{
					title: 'Style 2',
					code: '[label style="2"]Your text[/label]',
				},
				{
					title: 'Style 3',
					code: '[label style="3"]Your text[/label]',
				},
				{
					title: 'Style 4',
					code: '[label style="4"]Your text[/label]',
				},
			],
		},
		{
			title: 'Badges',
			code: '[badge]12[/badge]',
			submenu: [
				{
					title: 'Style 1',
					code: '[badge style="1"]12[/badge]',
				},
				{
					title: 'Style 2',
					code: '[badge style="2"]12[/badge]',
				},
				{
					title: 'Style 3',
					code: '[badge style="3"]12[/badge]',
				},
				{
					title: 'Style 4',
					code: '[badge style="4"]12[/badge]',
				},
			],
		},
		{
			title: 'Code',
			code: '[code]Your code[/code]',
			submenu: [
				{
					title: 'Style 1',
					code: '[code style="1"]Your code[/code]',
				},
				{
					title: 'Style 2',
					code: '[code style="2"]Your code[/code]',
				},
				{
					title: 'Style 3',
					code: '[code style="3"]Your code[/code]',
				},
			],
		},
		{
			title: 'Text blocks',
			code: '',
			submenu: [
				{
					title: 'Text block - style 1',
					code: '[textblock style="1"]Your text[/textblock]',
				},
				{
					title: 'Text block - style 2',
					code: '[textblock style="2"]Your text[/textblock]',
				},
				{
					title: 'Text block - style 3',
					code: '[textblock style="3"]Your text[/textblock]',
				},
				{
					title: 'Text block - style 4',
					code: '[textblock style="4"]Your text[/textblock]',
				},
				{
					title: 'Text block - style 5',
					code: '[textblock style="5"]Your text[/textblock]',
				},
				{
					title: 'Text block - style 6',
					code: '[textblock style="6"]Your text[/textblock]',
				},
				{
					title: 'Text block - style 7',
					code: '[textblock style="7"]Your text[/textblock]',
				},
				{
					title: 'Text block - style 8',
					code: '[textblock style="8"]Your text[/textblock]',
				},
				{
					title: 'Text block - style 9',
					code: '[textblock style="9"]Your text[/textblock]',
				},
				{
					title: 'Number block - style 1',
					code: '[numblock num="NUMBER" style="1"]Your text[/numblock]',
				},
				{
					title: 'Number block - style 2',
					code: '[numblock num="NUMBER" style="2"]Your text[/numblock]',
				},
				{
					title: 'Number block - style 3',
					code: '[numblock num="NUMBER" style="3"]Your text[/numblock]',
				},
				{
					title: 'Floated block - left',
					code: '[floated align="left"]Your text[/floated]',
				},
				{
					title: 'Floated block - right',
					code: '[floated align="right"]Your text[/floated]',
				},
				{
					title: 'Floaded block - center',
					code: '[floated align="center"]Your text[/floated]',
				},
			],
		},
		{
			title: 'Quotes',
			code: '',
			submenu: [
				{
					title: 'Quote - style 1',
					code: '[quote style="1" author="Author"]Text[/quote]',
				},
				{
					title: 'Quote - style 2',
					code: '[quote style="2" author="Author"]Text[/quote]',
				},
				{
					title: 'Quote - style 3',
					code: '[quote style="3" author="Author"]Text[/quote]',
				},
				{
					title: 'Quote - style 4',
					code: '[quote style="4" author="Author"]Text[/quote]',
				},
			],
		},
		{
			title: 'Lists',
			code: '',
			submenu: [
				{
					title: 'Ordered list - style 1',
					code: '[olist style="1"]<br />item1<br />item2<br />item3<br />[/olist]',
				},
				{
					title: 'Ordered list - style 2',
					code: '[olist style="2"]<br />item1<br />item2<br />item3<br />[/olist]',
				},
				{
					title: 'Ordered list - style 3',
					code: '[olist style="3"]<br />item1<br />item2<br />item3<br />[/olist]',
				},
				{
					title: 'Ordered list - style 4',
					code: '[olist style="4"]<br />item1<br />item2<br />item3<br />[/olist]',
				},
				{
					title: 'Unordered list - style 1',
					code: '[ulist style="1"]<br />item1<br />item2<br />item3<br />[/ulist]',
				},
				{
					title: 'Unordered list - style 2',
					code: '[ulist style="2"]<br />item1<br />item2<br />item3<br />[/ulist]',
				},
				{
					title: 'Unordered list - style 3',
					code: '[ulist style="3"]<br />item1<br />item2<br />item3<br />[/ulist]',
				},
				{
					title: 'Unordered list - style 4',
					code: '[ulist style="4"]<br />item1<br />item2<br />item3<br />[/ulist]',
				},
				{
					title: 'Unordered list - style 5',
					code: '[ulist style="5"]<br />item1<br />item2<br />item3<br />[/ulist]',
				},
				{
					title: 'Unordered list - style 6',
					code: '[ulist style="6"]<br />item1<br />item2<br />item3<br />[/ulist]',
				},
				{
					title: 'Unordered list - style 7',
					code: '[ulist style="7"]<br />item1<br />item2<br />item3<br />[/ulist]',
				},
				{
					title: 'Unordered list - style 8',
					code: '[ulist style="8"]<br />item1<br />item2<br />item3<br />[/ulist]',
				},
			],
		},
		{
			title: 'Button',
			code: '[button]Your text[/button]',
			submenu: [
				{
					title: 'Add a button',
					code: '[button text="Call to action" link="https://google.com" background_color="#fc0"][/button]',
				},
				{
					title: 'Style 2',
					code: '[button style="2"]Your text[/button]',
				},
				{
					title: 'Style 3',
					code: '[button style="3"]Your text[/button]',
				},
				{
					title: 'Style 4',
					code: '[button style="4"]Your text[/button]',
				},
				{
					title: 'Style 5',
					code: '[button style="5"]Your text[/button]',
				},
				{
					title: 'Style 6',
					code: '[button style="6"]Your text[/button]',
				},
			],
		},
		{
			title: 'Legend',
			code: '[legend title="Title"]text[/legend]',
			submenu: [
				{
					title: 'Style 1',
					code: '[legend title="Title" style="1"]text[/legend]',
				},
				{
					title: 'Style 2',
					code: '[legend title="Title" style="2"]text[/legend]',
				},
				{
					title: 'Style 3',
					code: '[legend title="Title" style="3"]text[/legend]',
				},
				{
					title: 'Style 4',
					code: '[legend title="Title" style="4"]text[/legend]',
				},
			],
		},
		{
			title: 'Tooltips',
			code: '[tip label="Label"]Text of the tooltip[/tip]',
			submenu: [
				{
					title: 'Link with tooltip - style 1',
					code: '[tip label="Label" style="1" href="URL"]Text of the tooltip[/tip]',
				},
				{
					title: 'Link with tooltip - style 2',
					code: '[tip label="Label" style="2" href="URL"]Text of the tooltip[/tip]',
				},
				{
					title: 'Link with tooltip - style 3',
					code: '[tip label="Label" style="3" href="URL"]Text of the tooltip[/tip]',
				},
				{
					title: 'Link with tooltip - style 4',
					code: '[tip label="Label" style="4" href="URL"]Text of the tooltip[/tip]',
				},
				{
					title: 'Text with tooltip - style 1',
					code: '[tip label="Label" style="1"]Text of the tooltip[/tip]',
				},
				{
					title: 'Text with tooltip - style 2',
					code: '[tip label="Label" style="2" href="URL"]Text of the tooltip[/tip]',
				},
				{
					title: 'Text with tooltip - style 3',
					code: '[tip label="Label" style="3"]Text of the tooltip[/tip]',
				},
				{
					title: 'Text with tooltip - style 4',
					code: '[tip label="Label" style="4" href="URL"]Text of the tooltip[/tip]',
				},
			],
		},
		{
			title: 'Template specific',
			code: '',
			submenu: [
				{
					title: 'Big header',
					code: '[bigheader]Hello, <span>everyone!</span>[/bigheader]',
				},
				{
					title: 'Medium header',
					code: '[mediumheader]Archive page template[/mediumheader]',
				},
				{
					title: 'Small header',
					code: '[smallheader]I’m new and really free Wordpress 3.4 template based on the brand-new GavernWP Framework[/smallheader]',
				},
				{
					title: 'Blue button',
					code: '[bluebtn url="#"]View details[/bluebtn]',
				},
				{
					title: 'Yellow button',
					code: '[yellowbtn url="#"]Download[/yellowbtn]',
				},
			],
		},
		{
			title: 'Other',
			code: '',
			submenu: [
				{
					title: 'Columns',
					code: '[columns]<br />[column]Content for the first column[/column]<br />[column]Content for the second column[/column]<br />[column]Content for the third column[/column]<br />[/columns]',
				},
				{
					title: 'Page URL',
					code: '[pageurl]',
				},
				{
					title: 'Text toggler',
					code: '[toggle header="Header text"]Toggled text[/toggle]',
				},
				{
					title: 'Opened text toggler',
					code: '[toggle header="Header text" open="true"]Toggled text[/toggle]',
				},
				{
					title: 'Raw text',
					code: '[raw]Your text[/raw]',
				},
				{
					title: 'RSS',
					code: '[rss href="URL"]Link text[/rss]',
				},
				{
					title: 'PDF viewer',
					code: '[pdf url="URL"]Text of the link[/pdf]',
				},
				{
					title: 'Private note',
					code: '[note]Your private note[/note]',
				},
				{
					title: 'Mail obfuscator',
					code: '[mail]email.to@obfuscate.com[/mail]',
				},
				{
					title: 'Content for members only',
					code: '[members_content]Content for the members only[/members_content]',
				},
				{
					title: 'Related posts',
					code: '[related limit="5"]',
				},
			],
		},
	];
	const dudeIcon = '" style="background-image: url(\'data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCIgdmlld0JveD0iMCAwIDQ4LjAxNiA0OC4wMTYiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQ4LjAxNiA0OC4wMTY7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8ZyBpZD0iTGVnb19TcXVhcmUiPgoJCTxnPgoJCQk8cGF0aCBkPSJNMjQuMTg1LDE1LjY3MmMtMi40MTQsMC00LjIzNS0xLjA1MS00LjIzNS0yLjQ0NGMwLTEuMzk0LDEuODIxLTIuNDQ1LDQuMjM1LTIuNDQ1czQuMjMzLDEuMDUxLDQuMjMzLDIuNDQ1ICAgICBTMjYuNTk5LDE1LjY3MiwyNC4xODUsMTUuNjcyeiBNMjQuMTg1LDEyLjI4M2MtMS43MDIsMC0yLjczNSwwLjY1Ny0yLjczNSwwLjk0NXMxLjAzMywwLjk0NCwyLjczNSwwLjk0NCAgICAgYzEuNzAxLDAsMi43MzMtMC42NTYsMi43MzMtMC45NDRDMjYuOTE4LDEyLjk1NCwyNS45NjEsMTIuMjgzLDI0LjE4NSwxMi4yODN6IiBmaWxsPSIjMDAwMDAwIi8+CgkJCTxwYXRoIGQ9Ik0yNC4xODUsMjAuMzI1Yy0yLjQxNCwwLTQuMjM1LTEuMDUxLTQuMjM1LTIuNDQ1di00LjY1MWMwLTAuNDE0LDAuMzM2LTAuNzUsMC43NS0wLjc1czAuNzUsMC4zMzYsMC43NSwwLjc1djQuNjUxICAgICBjMCwwLjI4OSwxLjAzMywwLjk0NSwyLjczNSwwLjk0NWMxLjc3NiwwLDIuNzMzLTAuNjcxLDIuNzMzLTAuOTQ1di00LjY1MWMwLTAuNDE0LDAuMzM2LTAuNzUsMC43NS0wLjc1czAuNzUsMC4zMzYsMC43NSwwLjc1ICAgICB2NC42NTFDMjguNDE4LDE5LjI3NCwyNi41OTksMjAuMzI1LDI0LjE4NSwyMC4zMjV6IiBmaWxsPSIjMDAwMDAwIi8+CgkJPC9nPgoJCTxnPgoJCQk8cGF0aCBkPSJNMzMuODU2LDEwLjMxMmMtMi40MTUsMC00LjIzNS0xLjA1LTQuMjM1LTIuNDQzYzAtMS4zOTUsMS44Mi0yLjQ0Niw0LjIzNS0yLjQ0NmMyLjQxNCwwLDQuMjM1LDEuMDUxLDQuMjM1LDIuNDQ2ICAgICBDMzguMDkyLDkuMjYxLDM2LjI3MSwxMC4zMTIsMzMuODU2LDEwLjMxMnogTTMzLjg1Niw2LjkyMmMtMS43MDIsMC0yLjczNSwwLjY1Ny0yLjczNSwwLjk0NmMwLDAuMjg4LDEuMDMzLDAuOTQzLDIuNzM1LDAuOTQzICAgICBzMi43MzUtMC42NTUsMi43MzUtMC45NDNDMzYuNTkyLDcuNTk0LDM1LjYzMyw2LjkyMiwzMy44NTYsNi45MjJ6IiBmaWxsPSIjMDAwMDAwIi8+CgkJCTxwYXRoIGQ9Ik0zMy44NTYsMTQuOTY0Yy0yLjQxNSwwLTQuMjM1LTEuMDUxLTQuMjM1LTIuNDQ1VjcuODY4YzAtMC40MTQsMC4zMzYtMC43NSwwLjc1LTAuNzVzMC43NSwwLjMzNiwwLjc1LDAuNzV2NC42NTEgICAgIGMwLDAuMjg5LDEuMDMzLDAuOTQ1LDIuNzM1LDAuOTQ1YzEuNzc2LDAsMi43MzUtMC42NzEsMi43MzUtMC45NDVWNy44NjhjMC0wLjQxNCwwLjMzNi0wLjc1LDAuNzUtMC43NXMwLjc1LDAuMzM2LDAuNzUsMC43NSAgICAgdjQuNjUxQzM4LjA5MiwxMy45MTMsMzYuMjcxLDE0Ljk2NCwzMy44NTYsMTQuOTY0eiIgZmlsbD0iIzAwMDAwMCIvPgoJCTwvZz4KCQk8Zz4KCQkJPHBhdGggZD0iTTE0LjM2NywxMC4zMjljLTIuNDE0LDAtNC4yMzUtMS4wNS00LjIzNS0yLjQ0M2MwLTEuMzk0LDEuODIxLTIuNDQ1LDQuMjM1LTIuNDQ1czQuMjM0LDEuMDUxLDQuMjM0LDIuNDQ1ICAgICBDMTguNjAxLDkuMjc5LDE2Ljc4MSwxMC4zMjksMTQuMzY3LDEwLjMyOXogTTE0LjM2Nyw2Ljk0MWMtMS43NzYsMC0yLjczNSwwLjY3MS0yLjczNSwwLjk0NWMwLDAuMjg4LDEuMDMzLDAuOTQzLDIuNzM1LDAuOTQzICAgICBjMS43MDEsMCwyLjczNC0wLjY1NSwyLjczNC0wLjk0M0MxNy4xMDEsNy42MTIsMTYuMTQzLDYuOTQxLDE0LjM2Nyw2Ljk0MXoiIGZpbGw9IiMwMDAwMDAiLz4KCQkJPHBhdGggZD0iTTE0LjM2NywxNC45ODJjLTIuNDE0LDAtNC4yMzUtMS4wNTEtNC4yMzUtMi40NDVWNy44ODZjMC0wLjQxNCwwLjMzNi0wLjc1LDAuNzUtMC43NWMwLjQxNCwwLDAuNzUsMC4zMzYsMC43NSwwLjc1ICAgICB2NC42NTFjMCwwLjI3NCwwLjk1OSwwLjk0NSwyLjczNSwwLjk0NWMxLjc3NiwwLDIuNzM0LTAuNjcxLDIuNzM0LTAuOTQ1VjcuODg2YzAtMC40MTQsMC4zMzYtMC43NSwwLjc1LTAuNzUgICAgIHMwLjc1LDAuMzM2LDAuNzUsMC43NXY0LjY1MUMxOC42MDEsMTMuOTMxLDE2Ljc4MSwxNC45ODIsMTQuMzY3LDE0Ljk4MnoiIGZpbGw9IiMwMDAwMDAiLz4KCQk8L2c+CgkJPGc+CgkJCTxwYXRoIGQ9Ik0yNC4yNSw0Ljg4OWMtMi40MTUsMC00LjIzNi0xLjA1LTQuMjM2LTIuNDQzQzIwLjAxNSwxLjA1MSwyMS44MzUsMCwyNC4yNSwwYzIuNDE0LDAsNC4yMzQsMS4wNTEsNC4yMzQsMi40NDYgICAgIEMyOC40ODUsMy44MzksMjYuNjY2LDQuODg5LDI0LjI1LDQuODg5eiBNMjQuMjUsMS41Yy0xLjcwMiwwLTIuNzM2LDAuNjU3LTIuNzM2LDAuOTQ2YzAsMC4yODgsMS4wMzQsMC45NDMsMi43MzYsMC45NDMgICAgIGMxLjcwMSwwLDIuNzM0LTAuNjU1LDIuNzM0LTAuOTQzQzI2Ljk4NSwyLjE3MSwyNi4wMjcsMS41LDI0LjI1LDEuNXoiIGZpbGw9IiMwMDAwMDAiLz4KCQkJPHBhdGggZD0iTTI0LjI1LDkuNTQyYy0yLjQxNSwwLTQuMjM2LTEuMDUxLTQuMjM2LTIuNDQ1VjIuNDQ2YzAtMC40MTQsMC4zMzYtMC43NSwwLjc1LTAuNzVzMC43NSwwLjMzNiwwLjc1LDAuNzV2NC42NTEgICAgIGMwLDAuMjg5LDEuMDM0LDAuOTQ1LDIuNzM2LDAuOTQ1YzEuNzAxLDAsMi43MzQtMC42NTYsMi43MzQtMC45NDVWMi40NDZjMC0wLjQxNCwwLjMzNi0wLjc1LDAuNzUtMC43NXMwLjc1LDAuMzM2LDAuNzUsMC43NSAgICAgdjQuNjUxQzI4LjQ4NSw4LjQ5MSwyNi42NjYsOS41NDIsMjQuMjUsOS41NDJ6IiBmaWxsPSIjMDAwMDAwIi8+CgkJPC9nPgoJCTxnPgoJCQk8cGF0aCBkPSJNMjMuOTAxLDQ4LjAxNmMtMC4xNjksMC0wLjMzOC0wLjA0My0wLjQ5LTAuMTI5TDQuNDA0LDM3LjE4NmMtMC4zMTYtMC4xNzgtMC41MS0wLjUxMS0wLjUxLTAuODcxVjEzLjMwNiAgICAgYzAtMC4zNTYsMC4xODktMC42ODUsMC40OTctMC44NjRjMC4zMDctMC4xNzksMC42ODctMC4xODEsMC45OTctMC4wMDVsMTkuMDEsMTAuOGMwLjMxMiwwLjE3OCwwLjUwNiwwLjUxLDAuNTA2LDAuODcgICAgIGwtMC4wMDMsMjIuOTA5YzAsMC4zNTUtMC4xODgsMC42ODUtMC40OTUsMC44NjNDMjQuMjUsNDcuOTcsMjQuMDc3LDQ4LjAxNiwyMy45MDEsNDguMDE2eiBNNS44OTUsMzUuNzI5bDE3LjAwNyw5LjU3NiAgICAgbDAuMDAzLTIwLjYxOGwtMTcuMDEtOS42NjNWMzUuNzI5eiIgZmlsbD0iIzAwMDAwMCIvPgoJCQk8cGF0aCBkPSJNMjMuOTA0LDQ4LjAxMWMtMC4xNzUsMC0wLjM1LTAuMDQ2LTAuNTA1LTAuMTM3Yy0wLjMwNy0wLjE3OS0wLjQ5NS0wLjUwOC0wLjQ5NS0wLjg2M1YyNC4xMDYgICAgIGMwLTAuMzYyLDAuMTk1LTAuNjk2LDAuNTEyLTAuODczbDE5LjIxNi0xMC43NTljMC4zMDktMC4xNzMsMC42ODgtMC4xNjksMC45OTQsMC4wMWMwLjMwNywwLjE3OSwwLjQ5NCwwLjUwOCwwLjQ5NCwwLjg2MyAgICAgbC0wLjAxOCwyMi44ODdjMCwwLjM2LTAuMTk1LDAuNjk1LTAuNTExLDAuODcxTDI0LjM5NCw0Ny44ODNDMjQuMjQzLDQ3Ljk2OSwyNC4wNzQsNDguMDExLDIzLjkwNCw0OC4wMTF6IE0yNC45MDQsMjQuNjkydjIwLjYxMSAgICAgbDE3LjE5OS05LjY1NGwwLjAxNi0yMC41OTZMMjQuOTA0LDI0LjY5MnoiIGZpbGw9IiMwMDAwMDAiLz4KCQkJPHBhdGggZD0iTTQyLjkxMiwxNC4yMjNjLTAuMTYsMC0wLjMyNC0wLjAzOS0wLjQ3Ny0wLjEyMWwtNS4yMjktMi44NGMtMC40ODQtMC4yNjQtMC42NjQtMC44NzEtMC40LTEuMzU2ICAgICBjMC4yNjQtMC40ODUsMC44NjktMC42NjQsMS4zNTUtMC40MDFsNS4yMjksMi44NGMwLjQ4NCwwLjI2NCwwLjY2NSwwLjg3MSwwLjQsMS4zNTZDNDMuNjEsMTQuMDM0LDQzLjI2NywxNC4yMjMsNDIuOTEyLDE0LjIyM3oiIGZpbGw9IiMwMDAwMDAiLz4KCQkJPHBhdGggZD0iTTMwLjYsNy43MTRjLTAuMTU0LDAtMC4zMTItMC4wMzYtMC40NTgtMC4xMTJsLTIuNDg3LTEuMjg1Yy0wLjQ5LTAuMjUzLTAuNjgzLTAuODU2LTAuNDMtMS4zNDcgICAgIGMwLjI1My0wLjQ5LDAuODU3LTAuNjg0LDEuMzQ4LTAuNDI5bDIuNDg3LDEuMjg1YzAuNDg5LDAuMjUzLDAuNjgzLDAuODU2LDAuNDMxLDEuMzQ3QzMxLjMxMiw3LjUxNywzMC45NjEsNy43MTQsMzAuNiw3LjcxNHoiIGZpbGw9IiMwMDAwMDAiLz4KCQkJPHBhdGggZD0iTTQuOTM3LDE0LjIyM2MtMC4zNTQsMC0wLjY5OC0wLjE4OS0wLjg4LTAuNTIyYy0wLjI2NC0wLjQ4NS0wLjA4NC0xLjA5MywwLjQwMS0xLjM1Nmw1LjIyOC0yLjg0ICAgICBjMC40ODMtMC4yNjMsMS4wOTMtMC4wODUsMS4zNTYsMC40YzAuMjY0LDAuNDg1LDAuMDg0LDEuMDkzLTAuNDAxLDEuMzU1bC01LjIyOCwyLjg0QzUuMjYyLDE0LjE4NCw1LjA5OCwxNC4yMjMsNC45MzcsMTQuMjIzeiIgZmlsbD0iIzAwMDAwMCIvPgoJCQk8cGF0aCBkPSJNMTcuNjI1LDcuNTQ4Yy0wLjM2MiwwLTAuNzEzLTAuMTk4LTAuODktMC41NDJjLTAuMjUzLTAuNDkxLTAuMDYxLTEuMDk0LDAuNDMxLTEuMzQ3bDIuNzM2LTEuNDEgICAgIGMwLjQ5LTAuMjUyLDEuMDk1LTAuMDYsMS4zNDcsMC40MzFjMC4yNTMsMC40OTEsMC4wNjEsMS4wOTQtMC40MzEsMS4zNDdsLTIuNzM2LDEuNDFDMTcuOTM2LDcuNTEyLDE3Ljc3OSw3LjU0OCwxNy42MjUsNy41NDh6IiBmaWxsPSIjMDAwMDAwIi8+CgkJPC9nPgoJPC9nPgoJPGc+Cgk8L2c+Cgk8Zz4KCTwvZz4KCTxnPgoJPC9nPgoJPGc+Cgk8L2c+Cgk8Zz4KCTwvZz4KCTxnPgoJPC9nPgoJPGc+Cgk8L2c+Cgk8Zz4KCTwvZz4KCTxnPgoJPC9nPgoJPGc+Cgk8L2c+Cgk8Zz4KCTwvZz4KCTxnPgoJPC9nPgoJPGc+Cgk8L2c+Cgk8Zz4KCTwvZz4KCTxnPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=\');';

	tinymce.PluginManager.add( 'palamut_shortcode_button', function( editor, url ) {
		// generate the menu structure
		const menu = getTemplateItems( shortcodeTemplates, editor );
		// Add a button that opens a window
		editor.addButton( 'palamut_shortcode_button', {
			type: 'menubutton',
			title: 'Insert Best Shortcodes',
			text: 'PDW Shortcode Blocks',
			tooltip: 'Theme shortcodes',
			icon: dudeIcon,
			menu: menu,
		} );
	} );

	function getTemplateItems( items, editor ) {
		const menuItems = [];

		for ( let i = 0; i < items.length; i++ ) {
			const item = {
				text: items[ i ].title,
				value: items[ i ].code,
			};

			if ( item.code !== '' ) {
				item.onclick = function( e ) {
					e.stopPropagation();
					editor.insertContent( this.value() );
				};
			}

			if ( items[ i ].submenu ) {
				item.menu = getTemplateItems( items[ i ].submenu, editor );
			}

			menuItems.push( item );
		}

		return menuItems;
	}
}() );
