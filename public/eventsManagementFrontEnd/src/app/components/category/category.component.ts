import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Category } from 'src/app/classes/category';
import { CategoryService } from 'src/app/services/category.service';


@Component({
  selector: 'app-category',
  templateUrl: './category.component.html',
  styleUrls: ['./category.component.css']
})


export class CategoryComponent implements OnInit {
  categories: Category[];

  constructor(private categoryService: CategoryService,
              private router: Router) { }


  ngOnInit() {
     this.getCategories();

  }

 getCategories() {
  this.categoryService.getCategories().subscribe(
    data => {
      this.categories = data;
    },
    (err) => {
      console.log(err);
    }
  );
 }

  deleteCategory(id) {
    this.categoryService.deleteCategory(id).subscribe(
      (data) => {
        if (data.valid === true) {
          let i = 0;
          for (i; i < this.categories.length; i++) {
            if (this.categories[i].id === id) {
              this.categories.splice(i, 1);
            }
          }
          alert('The category is well deleted');
          console.log(this.categories);

          this.router.navigate(['/categories']);
        } else {
           console.log(' error ');
        }
      }
    );
  }
}
