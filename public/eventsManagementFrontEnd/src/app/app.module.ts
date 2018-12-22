import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { FormsModule } from '@angular/forms';

import { CategoryComponent } from './components/category/category.component';
import { AddCategoryComponent } from './components/add-category/add-category.component';
import { UpdateCategoryComponent } from './components/update-category/update-category.component';
import { AddEventComponent } from './components/event/add-event/add-event.component';
import { DisplayEventsComponent } from './components/event/display-events/display-events.component';
import { UpdateEventComponent } from './components/event/update-event/update-event.component';

@NgModule({
  declarations: [
    AppComponent,
    CategoryComponent,
    AddCategoryComponent,
    UpdateCategoryComponent,
    AddEventComponent,
    DisplayEventsComponent,
    UpdateEventComponent,
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    AppRoutingModule,
    FormsModule,
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
