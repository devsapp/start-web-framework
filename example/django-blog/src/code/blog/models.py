from django.db import models
from mdeditor.fields import MDTextField


class TagsModel(models.Model):
    tid = models.AutoField(primary_key=True)
    name = models.CharField(max_length=30, verbose_name="标签名称", unique=True)
    remark = models.TextField(null=True, blank=True, verbose_name="备注说明")

    def __unicode__(self):
        return self.name

    def __str__(self):
        return self.name

    class Meta:
        verbose_name = '标签'
        verbose_name_plural = '标签'


class CategoryModel(models.Model):
    cid = models.AutoField(primary_key=True)
    name = models.CharField(max_length=30, verbose_name="名称", unique=True)
    sort = models.IntegerField(default=999, verbose_name="排序")
    remark = models.TextField(null=True, blank=True, verbose_name="备注说明")

    def __unicode__(self):
        return self.name

    def __str__(self):
        return self.name

    class Meta:
        verbose_name = '分类'
        verbose_name_plural = '分类'


class ArticleModel(models.Model):
    aid = models.AutoField(primary_key=True)
    title = models.CharField(max_length=50, verbose_name="文章标题", unique=True)
    desc = models.TextField(verbose_name="文章描述")
    content = MDTextField("内容")
    watched = models.IntegerField(default=0, verbose_name="点击次数")
    publish = models.DateTimeField(auto_created=True, auto_now_add=True, verbose_name="发布时间")
    category = models.ForeignKey(CategoryModel, on_delete=models.CASCADE, blank=True, null=True, verbose_name="分类")
    tag = models.ManyToManyField(TagsModel, verbose_name="标签")

    def __unicode__(self):
        return self.title

    def __str__(self):
        return self.title

    class Meta:
        verbose_name = '文章'
        verbose_name_plural = '文章'


class CommentsModel(models.Model):
    cid = models.AutoField(primary_key=True)
    content = models.TextField(verbose_name="评论内容")
    publish = models.DateTimeField(auto_now_add=True, verbose_name="发布时间")
    username = models.CharField(max_length=50, verbose_name="用户")
    qq = models.CharField(max_length=13, blank=True, null=True, verbose_name="QQ号")
    email = models.CharField(max_length=50, verbose_name="邮箱")
    reply = models.TextField(verbose_name="回复", blank=True, null=True)
    show = models.BooleanField(default=True, verbose_name="是否显示")
    article_title = models.CharField(max_length=50, verbose_name="文章")
    article = models.ForeignKey(ArticleModel, on_delete=models.CASCADE, )

    def __unicode__(self):
        return self.content

    def __str__(self):
        return self.content

    class Meta:
        verbose_name = '评论'
        verbose_name_plural = '评论'
