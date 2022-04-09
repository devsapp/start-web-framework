"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.DefaultErrorFilter = void 0;
const decorator_1 = require("@midwayjs/decorator");
let DefaultErrorFilter = class DefaultErrorFilter {
    async catch(err, ctx) {
        // 所有的未分类错误会到这里
        return {
            success: false,
            message: err.message,
        };
    }
};
DefaultErrorFilter = __decorate([
    decorator_1.Catch()
], DefaultErrorFilter);
exports.DefaultErrorFilter = DefaultErrorFilter;
//# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiZGVmYXVsdC5maWx0ZXIuanMiLCJzb3VyY2VSb290IjoiL1VzZXJzL3lrL2hlaW1hbmJhL2NuLXNlcnZlcmxlc3Mvc2VydmVybGVzcy9hcHBsaWNhdGlvbi9zdGFydC13ZWItZnJhbWV3b3JrL3dlYi1mcmFtZXdvcmsvbm9kZWpzL2N1c3RvbS1ydW50aW1lL21pZHdheS1rb2Evc3JjL2NvZGUvc3JjLyIsInNvdXJjZXMiOlsiZmlsdGVyL2RlZmF1bHQuZmlsdGVyLnRzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiI7Ozs7Ozs7OztBQUFBLG1EQUE0QztBQUk1QyxJQUFhLGtCQUFrQixHQUEvQixNQUFhLGtCQUFrQjtJQUM3QixLQUFLLENBQUMsS0FBSyxDQUFDLEdBQVUsRUFBRSxHQUFZO1FBQ2xDLGVBQWU7UUFDZixPQUFPO1lBQ0wsT0FBTyxFQUFFLEtBQUs7WUFDZCxPQUFPLEVBQUUsR0FBRyxDQUFDLE9BQU87U0FDckIsQ0FBQztJQUNKLENBQUM7Q0FDRixDQUFBO0FBUlksa0JBQWtCO0lBRDlCLGlCQUFLLEVBQUU7R0FDSyxrQkFBa0IsQ0FROUI7QUFSWSxnREFBa0IifQ==