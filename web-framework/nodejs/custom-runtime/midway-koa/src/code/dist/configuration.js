"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.ContainerLifeCycle = void 0;
const decorator_1 = require("@midwayjs/decorator");
const koa = require("@midwayjs/koa");
const validate = require("@midwayjs/validate");
const info = require("@midwayjs/info");
const path_1 = require("path");
// import { DefaultErrorFilter } from './filter/default.filter';
// import { NotFoundFilter } from './filter/notfound.filter';
const report_middleware_1 = require("./middleware/report.middleware");
let ContainerLifeCycle = class ContainerLifeCycle {
    async onReady() {
        // add middleware
        this.app.useMiddleware([report_middleware_1.ReportMiddleware]);
        // add filter
        // this.app.useFilter([NotFoundFilter, DefaultErrorFilter]);
    }
};
__decorate([
    decorator_1.App(),
    __metadata("design:type", Object)
], ContainerLifeCycle.prototype, "app", void 0);
ContainerLifeCycle = __decorate([
    decorator_1.Configuration({
        imports: [
            koa,
            validate,
            {
                component: info,
                enabledEnvironment: ['local'],
            },
        ],
        importConfigs: [path_1.join(__dirname, './config')],
    })
], ContainerLifeCycle);
exports.ContainerLifeCycle = ContainerLifeCycle;
//# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiY29uZmlndXJhdGlvbi5qcyIsInNvdXJjZVJvb3QiOiIvVXNlcnMveWsvaGVpbWFuYmEvY24tc2VydmVybGVzcy9zZXJ2ZXJsZXNzL2FwcGxpY2F0aW9uL3N0YXJ0LXdlYi1mcmFtZXdvcmsvd2ViLWZyYW1ld29yay9ub2RlanMvY3VzdG9tLXJ1bnRpbWUvbWlkd2F5LWtvYS9zcmMvY29kZS9zcmMvIiwic291cmNlcyI6WyJjb25maWd1cmF0aW9uLnRzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7OztBQUFBLG1EQUF5RDtBQUN6RCxxQ0FBcUM7QUFDckMsK0NBQStDO0FBQy9DLHVDQUF1QztBQUN2QywrQkFBNEI7QUFDNUIsZ0VBQWdFO0FBQ2hFLDZEQUE2RDtBQUM3RCxzRUFBa0U7QUFhbEUsSUFBYSxrQkFBa0IsR0FBL0IsTUFBYSxrQkFBa0I7SUFJN0IsS0FBSyxDQUFDLE9BQU87UUFDWCxpQkFBaUI7UUFDakIsSUFBSSxDQUFDLEdBQUcsQ0FBQyxhQUFhLENBQUMsQ0FBQyxvQ0FBZ0IsQ0FBQyxDQUFDLENBQUM7UUFDM0MsYUFBYTtRQUNiLDREQUE0RDtJQUM5RCxDQUFDO0NBQ0YsQ0FBQTtBQVJDO0lBREMsZUFBRyxFQUFFOzsrQ0FDZTtBQUZWLGtCQUFrQjtJQVg5Qix5QkFBYSxDQUFDO1FBQ2IsT0FBTyxFQUFFO1lBQ1AsR0FBRztZQUNILFFBQVE7WUFDUjtnQkFDRSxTQUFTLEVBQUUsSUFBSTtnQkFDZixrQkFBa0IsRUFBRSxDQUFDLE9BQU8sQ0FBQzthQUM5QjtTQUNGO1FBQ0QsYUFBYSxFQUFFLENBQUMsV0FBSSxDQUFDLFNBQVMsRUFBRSxVQUFVLENBQUMsQ0FBQztLQUM3QyxDQUFDO0dBQ1csa0JBQWtCLENBVTlCO0FBVlksZ0RBQWtCIn0=