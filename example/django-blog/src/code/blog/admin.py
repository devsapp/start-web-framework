from django.contrib import admin
from blog.models import TagsModel, ArticleModel, CategoryModel, CommentsModel

admin.site.site_header = 'Serverless Blog'
admin.site.site_title = 'Serverless Blog'


# Register your models here.

class TagsModelAdmin(admin.ModelAdmin):
    ordering = ('-tid',)
    list_display = ('tid', 'name')
    list_editable = ('name',)
    list_display_links = ('tid',)


class ArticleModelAdmin(admin.ModelAdmin):
    ordering = ('-aid',)
    list_display = ('aid', 'title', 'category', 'watched', 'publish')
    list_editable = ('watched',)
    list_display_links = ('aid', 'title')


class CategoryModelAdmin(admin.ModelAdmin):
    ordering = ('-cid',)
    list_display = ('cid', 'name', 'sort')
    list_editable = ('sort',)
    list_display_links = ('cid', 'name')


class CommentsModelAdmin(admin.ModelAdmin):
    ordering = ('-cid',)
    list_display = ('cid', 'username', 'publish', 'content', 'show')
    list_editable = ('show',)
    list_display_links = ('cid', 'username',)


admin.site.register(TagsModel, TagsModelAdmin)
admin.site.register(ArticleModel, ArticleModelAdmin)
admin.site.register(CategoryModel, CategoryModelAdmin)
admin.site.register(CommentsModel, CommentsModelAdmin)
