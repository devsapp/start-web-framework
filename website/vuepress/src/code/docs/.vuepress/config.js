module.exports = {
  title: 'VuePress',
  description: 'Just playing around',
  themeConfig: {
    nav: [
      { text: '指南', link: '/intro/' },
      { text: '配置', link: '/basic-config/' },
      { text: 'Github', link: 'https://google.com' },
    ],
    sidebar: [
      '/',
      '/intro/',
      '/basic-config/'
    ]
  }
}