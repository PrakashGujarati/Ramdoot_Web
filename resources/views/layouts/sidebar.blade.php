<!-- sidebar @s -->
<div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="html/index.html" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{ asset('assets/images/logo.png')}}" srcset="{{ asset('assets/images/logo2x.png 2x') }}" alt="logo">
                <img class="logo-dark logo-img" src="{{ asset('assets/images/logo-dark.png') }}" srcset="{{ asset('assets/images/logo-dark2x.png 2x')}}" alt="logo-dark">
                <img class="logo-small logo-img logo-img-small" src="{{ asset('assets/images/logo-small.png') }}" srcset="{{ asset('assets/images/logo-small2x.png 2x')}}" alt="logo-small">
            </a>
        </div>
        <div class="nk-menu-trigger mr-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="nk-menu-item @if(\Request::route()->getName() == 'dashboard') active @endif">
                        <a href="{{ route('dashboard') }}" class="nk-menu-link">    
                            <span class="nk-menu-icon"><em class="icon ni ni-masonry-fill"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    @canany(['Board-view','Medium-view','Standard-view','Semester-view'])
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-layers-fill"></em></span>
                            <span class="nk-menu-text">Resources</span>
                        </a>
                        <ul class="nk-menu-sub">

                            @canany(['Board-view'])

                            <li class="nk-menu-item @if(\Request::route()->getName() == 'board.index' || \Request::route()->getName() == 'board.create' || \Request::route()->getName() == 'board.edit') active @endif">
                                <a href="{{ route('board.create') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Board / Organisation</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany

                            @canany(['Medium-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'medium.index' || \Request::route()->getName() == 'medium.create' || \Request::route()->getName() == 'medium.edit') active @endif">
                                <a href="{{ route('medium.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Medium</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany
                            @canany(['Standard-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'standard.index' || \Request::route()->getName() == 'standard.create' || \Request::route()->getName() == 'standard.edit') active @endif">
                                <a href="{{ route('standard.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Standard / Class</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany
                           
                            @canany(['Subject-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'subject.index' || \Request::route()->getName() == 'subject.create' || \Request::route()->getName() == 'subject.edit') active @endif">
                                <a href="{{ route('subject.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Subject</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany
                            @canany(['Semester-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'semester.index' || \Request::route()->getName() == 'semester.create' || \Request::route()->getName() == 'semester.edit') active @endif">
                                <a href="{{ route('semester.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Semester</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany
                            @canany(['Unit-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'unit.index' || \Request::route()->getName() == 'unit.create' || \Request::route()->getName() == 'unit.edit') active @endif">
                                <a href="{{ route('unit.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Unit</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany
                        </ul><!-- .nk-menu-sub -->
                    </li>
                    @endcanany
                 
                    @canany(['Feature-view'])
                    <li class="nk-menu-item @if(\Request::route()->getName() == 'feature.index' || \Request::route()->getName() == 'feature.create' || \Request::route()->getName() == 'feature.edit') active @endif">
                        <a href="{{ route('feature.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                            <span class="nk-menu-text">Menu Name</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    @endcanany

                    @canany(['Book-view','Note-view','Video-view','Solution-view','Material-view','Paper-view','Worksheet-view'])
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-view-group-fill"></em></span>
                            <span class="nk-menu-text">Data Content</span>
                        </a>
                        <ul class="nk-menu-sub">
                            @canany(['Book-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'book.index' || \Request::route()->getName() == 'book.create' || \Request::route()->getName() == 'book.edit') active @endif">
                                <a href="{{ route('book.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Book</span>
                                </a>
                            </li><!-- .nk-menu-item -->    
                            @endcanany
                            @canany(['Note-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'note.index' || \Request::route()->getName() == 'note.create' || \Request::route()->getName() == 'note.edit') active @endif">
                                <a href="{{ route('note.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Note</span>
                                </a>
                            </li>
                            @endcanany
                            @canany(['Video-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'videos.index' || \Request::route()->getName() == 'videos.create' || \Request::route()->getName() == 'videos.edit') active @endif">
                                <a href="{{ route('videos.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Videos</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany
                            @canany(['Solution-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'solution.index' || \Request::route()->getName() == 'solution.create' || \Request::route()->getName() == 'solution.edit') active @endif">
                                <a href="{{ route('solution.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Solution</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany
                            @canany(['Material-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'material.index' || \Request::route()->getName() == 'material.create' || \Request::route()->getName() == 'material.edit') active @endif">
                                <a href="{{ route('material.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Material</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany
                            @canany(['Paper-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'paper.index' || \Request::route()->getName() == 'paper.create' || \Request::route()->getName() == 'paper.edit') active @endif">
                                <a href="{{ route('paper.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Paper</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany
                            @canany(['Worksheet-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'worksheet.index' || \Request::route()->getName() == 'worksheet.create' || \Request::route()->getName() == 'worksheet.edit') active @endif">
                                <a href="{{ route('worksheet.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Worksheet</span>
                                </a>
                            </li><!-- .nk-menu-item -->

                            
                            @endcanany
                            @canany(['Question-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'question.index' || \Request::route()->getName() == 'question.create' || \Request::route()->getName() == 'question.edit') active @endif">
                                <a href="{{ route('question.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">MCQ Question</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany
                        </ul><!-- .nk-menu-sub -->
                    </li>
                    @endcanany
                    @canany(['Question-view'])               
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-view-group-fill"></em></span>
                            <span class="nk-menu-text">Question Bank</span>
                        </a>
                         
                        <ul class="nk-menu-sub">
                            @canany(['Question-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'question.index' || \Request::route()->getName() == 'question.create' || \Request::route()->getName() == 'question.edit') active @endif">
                                <a href="{{ route('question.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Question</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany
                        </ul><!-- .nk-menu-sub -->
                    </li>
                    @endcanany

                    @canany(['Exam-view','ExamQuestion-view','ExamStudent-view'])
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-view-group-fill"></em></span>
                            <span class="nk-menu-text">Exam Data</span>
                        </a>
                        <ul class="nk-menu-sub">
                            @canany(['Exam-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'exam.index' || 
                                \Request::route()->getName() == 'exam.create' || \Request::route()->getName() == 'exam.edit') active @endif">
                                <a href="{{ route('exam.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Create Exam</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany
                            @canany(['ExamQuestion-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'exam_question.index' || 
                                \Request::route()->getName() == 'exam_question.create' || 
                                \Request::route()->getName() == 'exam_question.edit') active @endif">
                                <a href="{{ route('exam_question.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Genrate Paper</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany
                            @canany(['ExamStudent-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'exam_student.index' || 
                                \Request::route()->getName() == 'exam_student.create' || \Request::route()->getName() == 'exam_student.edit') active @endif">
                                <a href="{{ route('exam_student.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Exam Result</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany
                        </ul><!-- .nk-menu-sub -->
                    </li>
                    @endcanany
                    
                    
                    <li class="nk-menu-item @if(\Request::route()->getName() == 'exam_student_question_answer.index' || \Request::route()->getName() == 'exam_student_question_answer.create' || \Request::route()->getName() == 'exam_student_question_answer.edit') active @endif">
                        <a href="{{ route('exam_student_question_answer.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                            <span class="nk-menu-text">Question/Answer</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    @canany(['Slider-view'])
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-align-right"></em></span>
                            <span class="nk-menu-text">Others</span>
                        </a>
                        <ul class="nk-menu-sub">
                            @canany(['Slider-view'])
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'slider.index' || \Request::route()->getName() == 'slider.create' || \Request::route()->getName() == 'slider.edit') active @endif">
                                <a href="{{ route('slider.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Slider</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            @endcanany
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'slider.index' || \Request::route()->getName() == 'slider.create' || \Request::route()->getName() == 'slider.edit') active @endif">
                                <a href="{{ route('question_type.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Question Type</span>
                                </a>
                            </li><!-- .nk-menu-item -->

                        </ul><!-- .nk-menu-sub -->
                    </li>
                    @endcanany

                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-align-right"></em></span>
                            <span class="nk-menu-text">Data ExcelSheet</span>
                        </a>
                        <ul class="nk-menu-sub">                            
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'generate.excel.sample') active @endif">
                                <a href="{{ route('generate.excel.sample') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Generate Excel</span>
                                </a>
                            </li><!-- .nk-menu-item -->                           
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'generate.specific.excel') active @endif">
                                <a href="{{ route('generate.specific.excel') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Specific Data in Excel</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'all_data_excel.index') active @endif">
                                <a href="{{ route('all_data_excel.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">All Data in Excel</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item @if(\Request::route()->getName() == 'import_excel.index') active @endif">
                                <a href="{{ route('import_excel.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-chevron-right"></em></span>
                                    <span class="nk-menu-text">Upload Excel</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                        </ul><!-- .nk-menu-sub -->
                    </li>
                    
                    

                    @canany(['Setting-view'])
                    <li class="nk-menu-item has-sub">
                        <a href="{{route('settings')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-align-right"></em></span>
                            <span class="nk-menu-text">Settings</span>
                        </a>
                    </li>             
                    @endcanany
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
<!-- sidebar-->
