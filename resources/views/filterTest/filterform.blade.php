<!DOCTYPE html>
<html>
<head>
    <title>How To Store Multiple Checkbox Value In Database using Laravel - NiceSnippets.com</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="showimages"></div>
            </div>
            <div class="col-md-6 offset-3 mt-5">
                <div class="card">
                    <div class="card-header bg-info">
                        <h6 class="text-white">How To Store Multiple Checkbox Value In Database using Laravel - NiceSnippets.com</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        </div>
                        <form method="post" action="{{ route('professionals.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label><strong>Name :</strong></label>
                                <input type="text" name="lastname" class="form-control" placeholder="lastname"/>
                                <input type="text" name="firstname" class="form-control" placeholder="firstname"/>
                                <input type="text" name="email" class="form-control" placeholder="email"/>
                                <input type="text" name="phoneNumber" class="form-control" placeholder="phoneNumber"/>
                                <input type="password" name="password" class="form-control" placeholder="password"/>
                                <input type="text" name="profession" class="form-control" placeholder="profession"/>
                                <input type="text" name="city" class="form-control" placeholder="city"/>
                                <input type="text" name="experienceYears" class="form-control" placeholder="experienceYears"/>
                                <input type="text" name="experienceDetails" class="form-control" placeholder="experienceDetails"/>
                                <input type="text" name="price" class="form-control" placeholder="price"/>
                                <input type="text" name="diplomas" class="form-control" placeholder="diplomas"/>
                                <input type="text" name="languages" class="form-control" placeholder="languages"/>
                            </div>  
                            <div class="form-group">
                                <label><strong>Category :</strong></label><br>
                                <label><input type="checkbox" name="skills[]" value="mobility">Mobilité</label>
                                <label><input type="checkbox" name="skills[]" value="cooking">Repas</label>
                                <label><input type="checkbox" name="skills[]" value="houseCleaning">Entretien</label>
                                <label><input type="checkbox" name="skills[]" value="clothesChange">Change</label>
                                <label><input type="checkbox" name="skills[]" value="reeducation">Rééducation</label>
                                <label><input type="checkbox" name="skills[]" value="hygiene"> Toilette</label>
                                <label><input type="checkbox" name="skills[]" value="nursing">Soin</label>
                                <label><input type="checkbox" name="skills[]" value="medication">Traitement</label>
                                <label><input type="checkbox" name="skills[]" value="entertainment">Compagnie</label>
                                <label><input type="checkbox" name="skills[]" value="transportation">Transport</label>
                                
                                
                            </div>  
                            <div class="form-group">
                                <label><strong>Description :</strong></label>
                                <textarea class="form-control" rows="4" cols="40" name="description"></textarea>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success btn-sm">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>