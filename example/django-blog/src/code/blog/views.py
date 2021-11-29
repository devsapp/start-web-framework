from django.shortcuts import render
from django.views.decorators.csrf import csrf_exempt
from django.core.paginator import *
from blog.sentence import SENTENCE
from blog.models import TagsModel, CategoryModel, ArticleModel, CommentsModel
import re
import random
import markdown

# Create your views here.

WebsiteInformation = {
    "host": "https://www.0duzhan.com",
    "name": "刘宇的博客",
    "keywords": "Anycodes,刘宇的博客,技术博客,浙江大学刘宇",
    "description": "这是刘宇的博客，简简单单分享一些小技巧，自豪的采用Django实现。"
}

# Create your views here.
getContentPictures = lambda content: re.findall('!\[]\((.*?)\)', content)
defaultPicUrl = "//serverless-blog.oss-cn-beijing.aliyuncs.com/files/defaultBlogPic/%s.png"
defaultPic = lambda content: getContentPictures(content)[0] if getContentPictures(content) else defaultPicUrl % (random.randint(0, 40))


def blogList(request):
    # 头部名人名言
    sentence = random.choice(SENTENCE)

    search = request.GET.get("search", None)
    category = request.GET.get("cate", None)
    tag = request.GET.get("tag", None)
    try:
        pageNum = int(request.GET.get("page", 1))
    except:
        pageNum = 1

    pageInformation = WebsiteInformation

    articleList = ArticleModel.objects.all().order_by("-aid")
    hotData = articleList.order_by("-watched")[0:3]

    if search:
        articleTempList = []
        for eveArticle in articleList:
            if search in eveArticle.title + eveArticle.content:
                articleTempList.append(eveArticle)
        articleList = articleTempList
        pageInformation['title'] = search + "搜索结果"
    elif category:
        categoryData = CategoryModel.objects.get(cid=category)
        articleList = articleList.filter(category=categoryData).order_by("-aid")
        pageInformation['title'] = categoryData.name
    elif tag:
        tagData = TagsModel.objects.get(tid=tag)
        articleList = articleList.filter(tag=tagData).order_by("-aid")
        pageInformation['title'] = tagData.name
    else:
        articleList = articleList
        pageInformation['title'] = "博客首页"

    tagsList = TagsModel.objects.all().order_by("?")[0:20]
    categoryList = CategoryModel.objects.all().order_by("-sort")
    articleCount = len(articleList) if search else articleList.count()

    firstData = None
    if articleCount > 0:
        firstData = articleList[0]
        firstPicData = defaultPic(firstData.content)
    if articleCount >= 1:
        articleList = articleList[1:]
    paginator = Paginator(articleList, 12)
    # 对传递过来的页面进行判断，页码最小为1，最大为分页器所得总页数
    if pageNum < 0:
        pageNum = 1
    if pageNum > paginator.num_pages:
        pageNum = paginator.num_pages
    if pageNum != 1:
        pageInformation['title'] = "第%d页 - %s" % (pageNum, pageInformation['title'])
    # 分页器获得当前页面的数据内容
    getArticleList = lambda articles: [(eve, defaultPic(eve.content)) for eve in articles]
    articleList = paginator.page(pageNum)
    articleResult = getArticleList(articleList)
    hotList = getArticleList(hotData)

    return render(request, "list.html", locals())


@csrf_exempt
def blogArticle(request):
    # 头部名人名言
    sentence = random.choice(SENTENCE)

    pageInformation = WebsiteInformation

    tagsList = TagsModel.objects.all().order_by("?")[0:20]
    categoryList = CategoryModel.objects.all().order_by("-sort")

    # 获取文章ID
    aidData = request.GET.get("aid")
    articleData = ArticleModel.objects.get(aid=aidData)
    articleData.content = markdown.markdown(articleData.content, extensions=[
        'markdown.extensions.extra',
        'markdown.extensions.codehilite',
        'markdown.extensions.toc',
    ])

    # 阅读此书自增1
    watched = int(articleData.watched) + 1
    ArticleModel.objects.filter(aid=aidData).update(watched=watched)

    articleList = ArticleModel.objects.all().order_by("-aid")
    articleCount = articleList.count()
    hotList = [(eve, defaultPic(eve.content)) for eve in articleList.order_by("-watched")[0:3]]

    if request.method == "POST":
        username = request.POST.get("name")
        email = request.POST.get("email")
        comment = request.POST.get("comment")

        CommentsModel.objects.create(
            username=username,
            email=email,
            content=comment,
            show=False,
            article_title=articleData.title,
            article=articleData,
        )
        status = "留言成功，我会尽快审核，给您反馈！感谢您的支持哦！"

    commenList = CommentsModel.objects.filter(article=aidData, show=True).order_by("-cid")

    return render(request, "content.html", locals())
